@extends("layouts.admin")

@section("main")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Events</h1>
    <div class="flex flex-wrap gap-2 items-end">
        <form action="" method="GET" class="text-gray-800 relative space-y-4">
            <div class="flex flex-wrap gap-x-2 gap-y-4">
                @role("admin")
                <select name="organized_by" id="organized_by"
                    class="px-2 py-2 outline-indigo-500 text-lg rounded-md min-w-40" aria-label="Added By">
                    <option value="">All</option>
                    <option value="{{ auth()->user()->uuid }}" @selected(auth()->user()->uuid ===
                        request("organized_by"))>Admin</option>
                    <optgroup label="Managers">
                        @foreach ($users['manager'] as $manager)
                        <option value="{{ $manager->uuid }}" @selected($manager->uuid ===
                            request("organized_by"))>{{ $manager->name }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Employees">
                        @foreach ($users['employee'] as $employee)
                        <option value="{{ $employee->uuid }}" @selected($employee->uuid ===
                            request("organized_by"))>{{ $employee->name }}</option>
                        @endforeach
                    </optgroup>
                </select>
                @endrole
                <div class="flex-1 flex gap-2 items-center">
                    <label for="start" class="font-medium min-w-fit">Starting Between</label>
                    <input type="datetime-local" name="start" id="start"
                        class="px-4 py-2 outline-none w-full rounded-md text-lg" value="{{ request("start") }}">
                    <label for="start" class="font-medium">And</label>
                    <input type="datetime-local" name="end" id="end"
                        class="px-4 py-2 outline-none w-full rounded-md text-lg" value="{{ request("start") }}">
                </div>
            </div>
            <div class=" relative">
                <x-shared.form.search name="search" placeholder="Search events by event name or venue name" />
            </div>
        </form>
        <x-shared.anchor-button href="/dashboard/events/addEvent"
            class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.plus class="w-7 h-7" />
            <span class="text-lg">Organize New Event</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($events->isEmpty())
<section class="flex-1 flex items-center justify-center gap-8">
    <h2 class="font-bold text-5xl text-gray-500">There Are No Upcoming Events...</h2>
</section>

@else
<ul class="px-6 py-4 flex flex-wrap gap-8 overflow-y-auto">
    @foreach ($events as $event)
    <li class="min-w-80">
        <x-admin.event-card :$event />
    </li>
    @endforeach
</ul>

@endif
@endsection