<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Inventory;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::where("start", "<=", now())->where("end", ">", now())->orderBy("start")->lazy();
        return view("pages.client.live-events", compact("events"));
    }

    public function upcomingEvents()
    {
        $events = Event::where("start", ">", now())->orderBy("start")->lazy();
        return view("pages.client.upcoming-events", compact("events"));
    }

    public function show(Event $event)
    {
        $event->load(["user", "items.images"]);
        // return $event;
        return view("pages.client.event-details", compact("event"));
    }

    public function item(Inventory $item)
    {
        $item->load("images");
        // return $item;
        return view("pages.client.item-details", compact("item"));
    }
}
