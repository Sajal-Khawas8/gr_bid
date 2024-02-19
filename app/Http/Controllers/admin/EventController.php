<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventItem;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\User;
use App\Notifications\EventOrganized;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    private function getInventory()
    {
        return auth()->user()->hasRole("admin") ?
            Inventory::with("images")
                ->whereDoesntHave("event")
                ->lazy() :
            Inventory::with("images")
                ->where("added_by", auth()->user()->uuid)
                ->whereDoesntHave("event")
                ->lazy();
    }
    public function index()
    {
        $this->authorize("viewAny", Event::class);
        $events = auth()->user()->hasRole('admin') ?
            Event::where("end", ">", now())
                ->filter(request(["organized_by", "search", "start", "end"]))
                ->lazy() :
            Event::where("end", ">", now())->where("organized_by", auth()->user()->uuid)
                ->filter(request(["search", "start", "end"]))
                ->lazy();

        $additionalData = cache()->remember("additionalEventData", now()->addDays(30), function () {
            $locations = Location::all();
            $users = User::role(["admin", "manager", "employee"])
                ->with("roles")->get()
                ->groupBy(function ($user) {
                    return $user->roles->first()->name;
                });
            return compact("locations", "users");
        });
        return view("pages.admin.events", [
            "events" => $events,
            "locations" => $additionalData["locations"],
            "users" => $additionalData["users"]
        ]);
    }

    public function create()
    {
        $this->authorize("create", Event::class);
        $inventory = $this->getInventory();
        if ($inventory->isEmpty()) {
            return back()->with("error", "There are no free items in the inventory. Please add some items to your inventory before organizing an event!!");
        }
        return view("pages.admin.add-event", compact("inventory"));
    }

    public function store(Request $req)
    {
        $this->authorize("create", Event::class);
        $inventory = $this->getInventory();

        $attributes = $req->validate([
            "name" => ["bail", "required", "min:3", "regex:/^[a-zA-Z\s\d]*$/"],
            "start" => ["bail", "required", "date", "after_or_equal:" . now()],
            "end" => ["bail", "required", "date", "after:start"],
            "items" => ["bail", "required"],
            "items.*" => [Rule::in($inventory->pluck("id"))],
            "venue" => ["bail", "required", "min:3"],
            "cover" => ["bail", "required", "image"],
            "description" => ["bail", "required", "min:3"],
        ]);
        $event = Event::create([
            "name" => $attributes["name"],
            "description" => $attributes["description"],
            "start" => $attributes["start"],
            "end" => $attributes["end"],
            "venue" => $attributes["venue"],
            "cover" => $attributes["cover"]->store("events"),
            "organized_by" => auth()->user()->uuid,
        ]);

        foreach ($attributes["items"] as $productId) {
            EventItem::create([
                "product_id" => $productId,
                "event_id" => $event->id,
            ]);
        }

        return redirect("/dashboard/events")->with("success", "New Event has been Added.");
    }

    public function edit(Event $event)
    {
        $this->authorize("update", $event);
        if (now()->diffAsCarbonInterval($event->start)->ceilHours()->hours <= 3) {
            return back()->with("error", "The event is about to start. You can not change anything in the event now.");
        }
        $inventory = $event->items->load("images")->merge($this->getInventory());
        return view("pages.admin.edit-event", compact("event", "inventory"));
    }

    public function update(Request $req, Event $event)
    {
        $this->authorize("update", $event);
        $inventory = $event->items->merge($this->getInventory());

        $attributes = $req->validate([
            "name" => ["bail", "nullable", "min:3", "regex:/^[a-zA-Z\s\d]*$/"],
            "start" => ["bail", "nullable", "date", "after_or_equal:today"],
            "end" => ["bail", "nullable", "date", "after:start"],
            "items" => ["bail"],
            "items.*" => [Rule::in($inventory->pluck("id"))],
            "venue" => ["bail", "nullable", "min:3"],
            "cover" => ["bail", "nullable", "image"],
            "description" => ["bail", "nullable", "min:3"],
        ]);

        $eventData = [
            "name" => $attributes["name"] ?? $event->name,
            "description" => $attributes["description"] ?? $event->description,
            "start" => $attributes["start"] ?? $event->start,
            "end" => $attributes["end"] ?? $event->end,
            "venue" => $attributes["venue"] ?? $event->venue,
        ];

        if ($req->hasFile("cover")) {
            $eventData["cover"] = $attributes["cover"]->store("events");
            Storage::delete($event->cover);
        }

        $event->update($eventData);

        $itemsToRemove = $req->items ?
            $event->items->pluck('id')->diff(collect($req->items))->values() :
            collect();
        $itemsToAdd = collect($req->items)
            ->diff($event->items->pluck('id'))->values();

        // Inserting new items
        foreach ($itemsToAdd ?? [] as $productId) {
            EventItem::create([
                'product_id' => $productId,
                'event_id' => $event->id
            ]);
        }

        // Removing old items
        if ($itemsToRemove->isNotEmpty()) {
            EventItem::where('event_id', $event->id)
                ->whereIn('product_id', $itemsToRemove)
                ->delete();
        }

        return redirect("/dashboard/events")->with("success", "Event Data updated Successfully");
    }

    public function destroy(Event $event)
    {
        $this->authorize("delete", $event);
        EventItem::where("event_id", $event->id)->delete();
        $event->delete();
        return redirect("/dashboard/events")->with("success", "Event deleted Successfully.");
    }
}
