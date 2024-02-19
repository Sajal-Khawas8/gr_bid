@extends("layouts.main")

@section("main")
@empty($events)
<section class="flex items-center justify-center h-[90vh]">
    <h1 class="font-semibold text-center text-6xl text-gray-500">There are no live events at this time. Please check
        upcoming events...</h1>
</section>
@else
<section class="px-16 py-8 space-y-4">
    <h1 class="text-4xl font-bold">Live Events</h1>
    <p class="text-gray-700">See what's popular across thousands of items.</p>
    <ul class="flex flex-col gap-6 py-6">
        @foreach ($events as $event)
        <li class="lg:h-[700px] grid lg:block">
            <x-client.event-card :$event />
        </li>
        @endforeach
    </ul>
</section>
@endempty
@endsection