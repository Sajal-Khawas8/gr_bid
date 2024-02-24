@extends("layouts.admin")

@section("main")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">GRBid Managers and Employees</h1>
    <div class="flex items-center gap-2">
        <form action="/dashboard/users" method="GET"
            class="text-gray-800 divide-gray-500 relative w-[500px] flex gap-2">
            <select name="role" class="px-2 py-2 outline-indigo-500 text-lg rounded-md">
                <option value="">All Users</option>
                @foreach ($groupedUsers as $role=>$searchUsers)
                <optgroup label="{{ ucfirst($role) . 's' }}">
                    <option value="{{ $role }}" @selected(request('role')===$role)>All {{ ucfirst($role) . 's' }}
                    </option>
                    @foreach ($searchUsers as $user)
                    <option value="{{ $user->uuid }}" @selected(request('role')===$user->uuid)>{{ $user->name }}
                    </option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
            <x-shared.form.search name="search" placeholder="Search users by name or email"
                value="{{ request('search') }}" />
        </form>
        <x-shared.form.error name="search" />
        <x-shared.anchor-button href="/dashboard/users/addUser"
            class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.plus class="w-7 h-7" />
            <span class="text-lg">Add New User</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($users->isEmpty())
<section class="flex-1 flex items-center justify-center">
    <h2 class="font-bold text-5xl text-gray-500">There are no Users...</h2>
</section>
@else
<div class="flex-1 px-6 overflow-y-auto">
    <ul class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($users as $user)
        <li class="p-3 bg-white rounded-md h-fit">
            <x-admin.user-card :$user updateAction="/dashboard/users/updateUser/{{ $user->uuid }}"
                deleteAction="/dashboard/users/deleteUser/{{ $user->uuid }}" />
        </li>
        @endforeach
    </ul>
</div>
@endif
@endsection