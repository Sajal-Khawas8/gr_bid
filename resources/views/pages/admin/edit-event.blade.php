@extends("layouts.admin")

@section("main")
<article class="py-6 space-y-8 overflow-y-auto">
    <h1 class="text-center text-4xl font-semibold"> Update Event </h1>
    <form action="/dashboard/events/updateEvent/{{ $event->id }}" method="post" enctype="multipart/form-data"
        class="space-y-8 max-w-md mx-auto">
        @csrf
        @method("PUT")
        <div>
            <x-shared.form.input name="name" placeholder="Event Name" :value="old('name', $event->name)" />
            <x-shared.form.error name="name" />
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-6">
            <div>
                <label for="start">Start of Event</label>
                <x-shared.form.input name="start" type="datetime-local" placeholder="Full Name"
                    :value="old('start', $event->start)" />
                <x-shared.form.error name="start" />
            </div>
            <div>
                <label for="end">End of Event</label>
                <x-shared.form.input name="end" type="datetime-local" placeholder="Full Name"
                    :value="old('end', $event->end)" />
                <x-shared.form.error name="end" />
            </div>
        </div>
        <div>
            <button type="button" class="text-indigo-600 hover:text-indigo-800 font-semibold"
                onclick="document.getElementById('itemsModal').classList.replace('hidden', 'flex')">Select Event
                Items</button>
            <x-shared.form.error name="items" />
            <x-shared.form.error name="items.*" />
        </div>
        <div id="itemsModal"
            class="absolute inset-0 !m-0 bg-gray-400/90 z-40 justify-center items-center overflow-y-auto hidden">
            <div class="absolute top-4 right-7">
                <button type="button"
                    onclick="document.getElementById('itemsModal').classList.replace('flex', 'hidden')">
                    <x-icons.close-circle class="w-8 h-8" />
                </button>
            </div>
            <article class="space-y-8 py-8">
                <h3 class="text-4xl font-semibold text-center">Select Event Items</h3>
                <ul class="grid sm:grid-cols-2 md:grid-cols-3 items-center gap-8 px-8">
                    @foreach ($inventory as $product)
                    <li class="relative max-w-80">
                        <input type="checkbox" name="items[]" id="product{{ $loop->iteration }}"
                            value="{{ $product->id }}" class="hidden peer" @checked(old('items') ?
                            in_array($product->id, old('items')) :
                        in_array($product->id, $event->items->pluck('id')->toArray()))>
                        <label for="product{{ $loop->iteration }}"
                            class="absolute inset-0 z-10 cursor-pointer peer-checked:ring-4 border-indigo-800 ring-sky-500 rounded-md"></label>
                        <div class="flex flex-wrap gap-4 items-center px-4 py-2 rounded-md shadow-md bg-white">
                            <div class="w-24 h-24 bg-slate-100">
                                <img src="{{ Storage::url($product->images->first()->url) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1 space-y-2">
                                <h2 class="font-semibold text-xl flex justify-between">{{ $product->name }}<span
                                        class="text-gray-500 text-lg">#{{ $product->id }}</span></h2>
                                <div class="flex justify-between gap-4">
                                    <dl class="flex flex-col justify-between">
                                        <div class="flex gap-2">
                                            <dt class="font-medium">Condition:</dt>
                                            <dd>{{ $product->condition }}</dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="font-medium">Category:</dt>
                                            <dd>{{ $product->category }}</dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="font-medium">Location:</dt>
                                            <dd>{{ $product->location }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="w-fit mx-auto">
                    <x-shared.button class="min-w-44"
                        onclick="document.getElementById('itemsModal').classList.replace('flex', 'hidden')">Proceed
                    </x-shared.button>
                </div>
            </article>
        </div>
        <div>
            <x-shared.form.input name="venue" placeholder="Event Venue" :value="old('venue', $event->venue)" />
            <x-shared.form.error name="venue" />
        </div>
        <div>
            <div class="flex items-center gap-3">
                <label for="cover">Choose Event Cover: </label>
                <x-shared.form.file-input name="cover" />
                <x-shared.button class="!w-fit px-0 bg-transparent hover:bg-transparent" title="View Uploaded Image"
                    onclick="document.getElementById('imageModal').classList.add('!flex')">
                    <x-icons.eye class="w-7 h-7 text-violet-700" />
                </x-shared.button>
                <section id="imageModal" class="hidden absolute inset-0 bg-gray-300/70 items-center justify-center">
                    <div class="relative w-96 bg-white py-4 space-y-2">
                        <h3 class="text-xl font-semibold text-center">Uploaded Cover</h3>
                        <x-shared.button class="absolute top-0.5 right-2 !w-fit bg-transparent hover:bg-transparent"
                            onclick="document.getElementById('imageModal').classList.remove('!flex')">
                            <x-icons.close-circle class="w-6 h-6 text-black" />
                        </x-shared.button>
                        <div class="py-4">
                            <img src="{{ Storage::url($event->cover) }}" alt="{{ $event->name }}"
                                class="w-52 h-52 mx-auto">
                        </div>
                    </div>
                </section>
            </div>
            <x-shared.form.error name="cover" />
        </div>
        <div>
            <x-shared.form.text-area name="description" placeholder="Event Description">
                {{ old('description', $event->description) }}
            </x-shared.form.text-area>
            <x-shared.form.error name="description" />
        </div>
        <x-shared.form.submit-button> Update Event </x-shared.form.submit-button>
    </form>
</article>
@endsection