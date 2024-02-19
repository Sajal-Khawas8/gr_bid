@extends('layouts.admin')

@section('main')
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Our Locations</h1>
    <div class="flex flex-wrap items-center gap-2">
        <form action="/dashboard/locations" method="GET" class="text-gray-800 divide-gray-500 relative w-[500px]">
            <x-shared.form.search name="search" placeholder="Search locations" />
        </form>
        <x-shared.form.error name="search" />
        <x-shared.anchor-button href="/dashboard/locations/addLocation"
            class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.plus class="w-7 h-7" />
            <span class="text-lg">Add New Location</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($locations->isEmpty())
<section class="flex-1 flex items-center justify-center gap-8">
    <h2 class="font-bold text-5xl text-gray-500">There Are No Locations...</h2>
</section>

@else
<ul class="px-6 flex flex-wrap gap-8 overflow-y-auto">
    @foreach ($locations as $location)
    <li class="px-5 py-3 bg-white rounded-md min-w-72 sm:min-w-80 relative">
        <x-admin.location-card :$location />
    </li>
    @endforeach
</ul>
@endif
@endsection