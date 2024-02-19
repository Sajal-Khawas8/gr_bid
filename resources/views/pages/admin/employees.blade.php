@extends("layouts.admin")

@section("main")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">GRBid Employees</h1>
    <div class="flex items-center gap-2">
        <form action="/dashboard/employees" method="GET" class="text-gray-800 divide-gray-500 relative w-[500px]">
            <x-shared.form.search name="search" placeholder="Search employees by name or email" />
        </form>
        <x-shared.form.error name="search" />
        <x-shared.anchor-button href="/dashboard/employees/addEmployee"
            class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.plus class="w-7 h-7" />
            <span class="text-lg">Add New Employee</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($employees->isEmpty())
<section class="flex-1 flex items-center justify-center">
    <h2 class="font-bold text-5xl text-gray-500">There are no employees...</h2>
</section>
@else
<div class="flex-1 px-6  overflow-y-auto">
    <ul class="flex flex-wrap gap-8">
        @foreach ($employees as $employee)
        <li class="p-3 bg-white rounded-md h-fit">
            <x-admin.user-card :user="$employee" updateAction="/dashboard/employees/updateEmployee/{{ $employee->uuid }}"
                deleteAction="/dashboard/employees/deleteEmployee/{{ $employee->uuid }}" />
        </li>
        @endforeach
    </ul>
</div>
@endif
@endsection