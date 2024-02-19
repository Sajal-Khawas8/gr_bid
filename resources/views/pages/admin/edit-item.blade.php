@extends("layouts.admin")

@section("main")
<article class="py-6 px-8 space-y-8 overflow-y-auto">
    <h1 class="text-center text-4xl font-semibold"> Update Item </h1>
    <form action="/dashboard/inventory/updateItem/{{ $product->id }}" method="post" enctype="multipart/form-data"
        class="space-y-8 max-w-md mx-auto">
        @csrf
        @method("PUT")
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div class="sm:col-span-2">
                <x-shared.form.input name="name" placeholder="Item Name" :value="old('name', $product->name)" />
                <x-shared.form.error name="name" />
            </div>
            <div>
                <x-shared.form.input type="number" step="0.01" name="bid" placeholder="Starting Bid"
                    :value="old('bid', $product->starting_bid)" />
                <x-shared.form.error name="bid" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-center">
            <div>
                <select name="category" class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600">
                    <option value="0">Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->name }}" @selected($product->category ===
                        $category->name)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-shared.form.error name="category" />
            </div>
            <div>
                <select name="condition" class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600">
                    <option value="0">Select Condition</option>
                    <option value="new" @selected($product->condition === "New")>New</option>
                    <option value="old" @selected($product->condition === "Old")>Second Hand</option>
                </select>
                <x-shared.form.error name="condition" />
            </div>
        </div>
        <div>
            <select name="location" class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600">
                <option value="0">Select Location</option>
                @foreach ($locations as $location)
                <option value="{{ $location }}" @selected($location===$product->location)>{{ $location }}</option>
                @endforeach
            </select>
            <x-shared.form.error name="location" />
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
            <button type="button" class="text-indigo-600 hover:text-indigo-800 font-semibold"
                onclick="document.getElementById('imagesModal').classList.replace('hidden', 'flex')">
                View and Remove old Images
            </button>
        </div>
        <div>
            <x-shared.form.text-area name="description" placeholder="Description">
                {{ old('description', $product->description) }}</x-shared.form.text-area>
            <x-shared.form.error name="description" />
        </div>
        <x-shared.form.submit-button> Update Item </x-shared.form.submit-button>
    </form>

    <div id="imagesModal" class="absolute inset-0 !m-0 bg-gray-400/90 z-40 justify-center items-center hidden">
        <div class="absolute top-4 right-7">
            <button type="button" onclick="document.getElementById('imagesModal').classList.replace('flex', 'hidden')">
                <x-icons.close-circle class="w-8 h-8" />
            </button>
        </div>
        @if ($product->images->isEmpty())
        <article>
            <h2 class="text-4xl font-semibold text-center">There are no images to show!!</h2>
        </article>
        @else
        <article class="space-y-8">
            <h2 class="text-4xl font-semibold text-center">Uploaded Images</h2>
            <form action="/dashboard/inventory/deleteImages/{{ $product->id }}" method="post"
                class="flex flex-col justify-center gap-y-6">
                @csrf
                @method("DELETE")
                <ul class="flex flex-wrap gap-4">
                    @foreach ($product->images as $image)
                    <li>
                        <input type="checkbox" name="deletedImages[]" id="image{{ $loop->iteration }}"
                            value="{{ $image->id }}" class="hidden peer">
                        <label for="image{{ $loop->iteration }}"
                            class="cursor-pointer inline-block w-28 h-28 peer-checked:ring-4 border-indigo-800 ring-sky-500 rounded-md">
                            <img src="{{ Storage::url($image->url) }}" alt="{{ $image->name }}"
                                class="w-full h-full object-cover rounded-md">
                        </label>
                    </li>
                    @endforeach
                </ul>
                <x-shared.form.submit-button class="max-w-72 mx-auto"> Delete Images </x-shared.form.submit-button>
            </form>
        </article>
        @endif

    </div>
</article>
@endsection