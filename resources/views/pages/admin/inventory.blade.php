@extends("layouts.admin")

@section("main")

<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Inventory</h1>
    <div class="flex items-center flex-wrap gap-2">
        <form action="" method="GET"
            class="text-gray-800 relative grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 xl:max-w-5xl gap-x-2 gap-y-4">
            <div class="rounded-md relative">
                <select name="category[]" id="category" multiple size="1"
                    class="w-full px-2 py-2 outline-indigo-500 text-lg rounded-md [&>*]:p-0.5"
                    aria-label="Select category">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->name }}" @selected(in_array($category->name, request('category')??[]))>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <x-icons.drop-down class="w-6 h-6 absolute top-1/2 -translate-y-1/2 right-1" />
            </div>
            <select name="condition" id="condition" class="px-2 py-2 outline-indigo-500 text-lg rounded-md"
                aria-label="Select conditions">
                <option value="">All Conditions</option>
                <option value="new" @selected(request('condition')==='new' )>New</option>
                <option value="old" @selected(request('condition')==='old' )>Second Hand</option>
            </select>
            <div class="rounded-md relative">
                <select name="location[]" id="location" multiple size="1"
                    class="w-full px-2 py-2 outline-indigo-500 text-lg rounded-md [&>*]:p-0.5"
                    aria-label="Select locations">
                    <option value="">All Locations</option>
                    @foreach ($locations as $location)
                    <option value="{{ $location->name }}" @selected(in_array($location->name, request('location')??[]))>
                        {{ $location->name }}
                    </option>
                    @endforeach
                </select>
                <x-icons.drop-down class="w-6 h-6 absolute top-1/2 -translate-y-1/2 right-1" />
            </div>
            @role("admin")
            <select name="added_by" id="added_by" class="px-2 py-2 outline-indigo-500 text-lg rounded-md"
                aria-label="Added By">
                <option value="">All</option>
                <option value="{{ auth()->user()->uuid }}" @selected(auth()->user()->uuid === request('added_by'))>Admin
                </option>
                <optgroup label="Managers">
                    @foreach ($users['manager'] as $manager)
                    <option value="{{ $manager->uuid }}" @selected($manager->uuid ===
                        request('added_by'))>{{ $manager->name }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Employees">
                    @foreach ($users['employee'] as $employee)
                    <option value="{{ $employee->uuid }}" @selected($employee->uuid ===
                        request('added_by'))>{{ $employee->name }}</option>
                    @endforeach
                </optgroup>
            </select>
            @endrole
            <div class="relative col-span-2">
                <x-shared.form.search name="search" placeholder="Search items" />
            </div>
        </form>
        <x-shared.anchor-button href="/dashboard/inventory/addItem"
            class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.plus class="w-7 h-7" />
            <span class="text-lg">Add New Item</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($inventory->isEmpty())
<section class="flex-1 flex items-center justify-center gap-8">
    <h2 class="font-bold text-5xl text-gray-500">There Are No Items in the Inventory...</h2>
</section>

@else
<ul class="px-6 py-4 flex flex-wrap gap-8 overflow-y-auto">
    @foreach ($inventory as $product)
    <li class="min-w-80">
        <x-admin.product-card :$product />
    </li>
    @endforeach
</ul>

@endif

@endsection