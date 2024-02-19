@extends("layouts.main")

@section("main")

@if ($liveEvents->isEmpty() && !$upcomingEvent)
<section class="px-16 py-10 h-screen bg-slate-200 flex items-center justify-center">
    <div>
        <h1 class="font-bold text-5xl">Coming Soon...</h1>
    </div>
</section>

@else

{{-- Intro Section --}}
<section class="px-16 py-10 h-screen bg-slate-200 flex items-center">
    <div>
        <h1 class="font-bold text-5xl">Join Our Next Auction! Find Your Equipment</h1>
    </div>
    <div class="hidden lg:block">
        <img src="{{ asset('watch.png') }}" alt="Item" class="w-[700px] aspect-square">
    </div>
</section>

{{-- Live Events --}}
<section id="events" class="px-16 py-8 space-y-4">
    <h2 class="text-3xl font-semibold">Trending Events</h2>
    <p class="text-gray-700">See what's popular across thousands of items.</p>
    @if($liveEvents->isEmpty())
    <p class="text-gray-500 text-center text-4xl font-semibold">There are no live events. Please check upcoming events
    </p>
    @else
    <div class="flex lg:items-center lg:h-[700px] flex-col lg:flex-row gap-6 py-6">
        <div class="flex-1 h-full grid lg:block">
            <x-client.event-card :event="$liveEvents->first()" />
        </div>
        @if ($liveEvents->skip(1)->isNotEmpty())
        <ul class="flex-1 h-full grid grid-rows-{{ $liveEvents->skip(1)->count() }} gap-6">
            @foreach ($liveEvents->skip(1) as $event)
            <li class="h-full lg:max-h-[655px]">
                <x-client.event-card :$event />
            </li>
            @endforeach
        </ul>
        @endif
    </div>
    <a href="/liveEvents" class="text-blue-500 font-medium flex gap-2 items-center justify-end">
        <span>View All</span>
        <x-icons.right-arrow class="w-5 h-5" />
    </a>
    @endif
</section>


{{-- Upcoming Events --}}
<section class="px-16 py-8 space-y-4">
    <h2 class="text-3xl font-semibold">Upcoming Events</h2>
    <p class="text-gray-700">See what's the next event waiting for you.</p>
    @empty($upcomingEvent)
    <p class="text-gray-500 text-center text-4xl font-semibold">There are no upcoming events. Please check live events
    </p>
    @else
    <div class="lg:h-[700px] py-6">
        <div class="h-full grid lg:block">
            <x-client.event-card :event="$upcomingEvent" />
        </div>
    </div>
    <a href="/upcomingEvents" class="text-blue-500 font-medium flex gap-2 items-center justify-end">
        <span>View All</span>
        <x-icons.right-arrow class="w-5 h-5" />
    </a>
    @endempty
</section>
@endif

@endsection