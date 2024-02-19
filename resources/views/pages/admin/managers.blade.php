@extends("layouts.admin")

@section("main")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">GRBid Managers</h1>
    <div class="flex items-center gap-2">
        <form action="/dashboard/managers" method="GET" class="text-gray-800 divide-gray-500 relative w-[500px]">
            <x-shared.form.search name="search" placeholder="Search managers by name or email" />
        </form>
        <x-shared.form.error name="search" />
        <x-shared.anchor-button href="/dashboard/managers/addManager"
            class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.plus class="w-7 h-7" />
            <span class="text-lg">Add New Manager</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($managers->isEmpty())
<section class="flex-1 flex items-center justify-center">
    <h2 class="font-bold text-5xl text-gray-500">There are no managers...</h2>
</section>
@else
<div class="flex-1 px-6  overflow-y-auto">
    <ul class="flex flex-wrap gap-8">
        @foreach ($managers as $manager)
        <li class="p-3 bg-white rounded-md h-fit">
            <x-admin.user-card :user="$manager" updateAction="/dashboard/managers/updateManager/{{ $manager->uuid }}"
                deleteAction="/dashboard/managers/deleteManager/{{ $manager->uuid }}" />
        </li>
        @endforeach
    </ul>
</div>
@endif
@endsection