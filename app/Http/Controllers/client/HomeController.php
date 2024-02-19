<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $liveEvents = Event::where("start", "<=", now())->where("end", ">", now())->orderBy("start")->limit(3)->get();
        $upcomingEvent = Event::where("start", ">", now())->first();
        return view("pages.client.index", compact("liveEvents", "upcomingEvent"));
    }
}
