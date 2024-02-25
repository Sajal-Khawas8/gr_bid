@extends("layouts.admin")

@section("main")
<article class="py-6 px-8 space-y-8 overflow-y-auto">
    <h1 class="text-center text-4xl font-semibold"> Add Item </h1>
    <form action="/dashboard/inventory/addItem" method="post" enctype="multipart/form-data"
        class="space-y-8 max-w-md mx-auto">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div class="sm:col-span-2">
                <x-shared.form.input name="name" placeholder="Item Name" />
                <x-shared.form.error name="name" />
            </div>
            <div>
                <x-shared.form.input type="number" step="0.01" name="bid" placeholder="Starting Bid" />
                <x-shared.form.error name="bid" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <div>
                <select name="category" class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600">
                    <option value="0">Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->name }}" @selected(old("category") && old("category")===$category->
                        name)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-shared.form.error name="category" />
            </div>
            <div class="">
                <select name="condition"
                    onchange="this.value==='old' ? document.getElementById('old_duration').classList.remove('hidden') : document.getElementById('old_duration').classList.add('hidden')"
                    class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600">
                    <option value="0">Select Condition</option>
                    <option value="new" @selected(old("condition") && old("condition")==="new" )>New</option>
                    <option value="old" @selected(old("condition") && old("condition")==="old" )>Second Hand</option>
                </select>
                <x-shared.form.error name="condition" />
            </div>
        </div>
        <div id="old_duration" class="{{ (old("condition") && old("condition")==="old") ? '' : 'hidden' }}">
            <div class="flex items-center gap-4">
                <label for="old_duration" class="min-w-fit">Months since purchase:</label>
                <x-shared.form.input type="number" name="old_months" placeholder="Months since purchase" />
            </div>
            <x-shared.form.error name="old_months" />
        </div>
        <div>
            <div class="flex items-center gap-3">
                <label for="profilePicture">Select Images: </label>
                <x-shared.form.file-input name="images[]" multiple />
            </div>
            <x-shared.form.error name="images" />
            <x-shared.form.error name="images.*" />
        </div>
        <div>
            <div class="flex gap-2 items-center">
                <label for="locations">Select Locations (You can select more than one):</label>
                <select name="locations[]"
                    class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600 [&>*]:p-0.5" multiple
                    size="1">
                    @foreach ($locations as $location)
                    <option value="{{ $location }}" @selected(old('locations') && in_array($location,
                        old('locations')))>
                        {{ $location }}</option>
                    @endforeach
                </select>
            </div>
            <x-shared.form.error name="locations" />
            <x-shared.form.error name="locations.*" />
        </div>
        <div>
            <x-shared.form.text-area name="description" placeholder="Description" />
            <x-shared.form.error name="description" />
        </div>
        <x-shared.form.submit-button> Add Item </x-shared.form.submit-button>
    </form>
</article>
@endsection