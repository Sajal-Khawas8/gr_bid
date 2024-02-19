@extends("layouts.main")

@section("main")
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-16 py-8 relative">
    <section class="col-span-2 h-fit space-y-10">
        <div class="h-[800px] aspect-square max-w-full my-5 mx-auto rounded-md bg-gray-300">
            <img id="item-img" src="{{ Storage::url($item->images->first()->url) }}"
                alt="{{ $item->name }}" class="h-full w-full object-fill rounded-md">
        </div>
        <form id="item-form" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 items-center gap-3 ">
            @foreach ($item->images as $image)
            <input type="radio" name="item" id="item{{ $loop->iteration }}" value="{{ Storage::url($image->url) }}" class="hidden peer/item{{ $loop->iteration }}"
                @checked($loop->first)
                onchange='document.getElementById("item-img").src = document.getElementById("item-form").item.value'>
            <label for="item{{ $loop->iteration }}"
                class="cursor-pointer peer-checked/item{{ $loop->iteration }}:border-2 rounded-md border-indigo-700 hover:outline outline-sky-500 bg-gray-300 w-fit">
                <img src="{{ Storage::url($image->url) }}" alt="{{ $item->name }}" class="h-20 sm:h-28 lg:h-40 object-cover rounded-md">
            </label>
            @endforeach
        </form>
    </section>
    <div class="relative">
        <section class="shadow-lg p-6 rounded-md h-fit sticky top-[130px] right-16 space-y-8">
            <h2 class="font-bold text-4xl">{{ $item->name }}</h2>
            <dl class="space-y-4 text-lg">
                <div class="flex gap-2">
                    <dt class="font-medium">Category:</dt>
                    <dd>{{ $item->category }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="font-medium">Item Condition:</dt>
                    <dd>{{ $item->condition }} {{ $item->old_months ? "(".$item->old_months . " Months)" : "" }}</dd>
                </div>
            </dl>
            <article class="space-y-3">
                <h3 class="font-medium text-xl">Description</h3>
                <p>{{ $item->description }}</p>
            </article>
            <dl class="flex gap-2">
                <dt class="font-medium">Starting Bid:</dt>
                <dd>${{ number_format($item->starting_bid, 2) }}</dd>
            </dl>
            <form action="#" method="post" class="flex gap-4 items-center">
                @csrf
                <div class="relative text-lg max-w-64">
                    <button type="button" class="absolute inset-y-0 bg-black text-white px-3.5 py-2 rounded-l-md left-0"
                        onclick="document.getElementById('bid-input').value = (parseFloat(document.getElementById('bid-input').value) - 1.00).toFixed(2)">
                        <x-icons.minus class="w-4 h-4" />
                    </button>
                    <button type="button"
                        class="absolute inset-y-0 bg-black text-white px-3.5 py-2 rounded-r-md right-0"
                        onclick="document.getElementById('bid-input').value = (parseFloat(document.getElementById('bid-input').value) + 1.00).toFixed(2)">
                        <x-icons.plus class="w-4 h-4" />
                    </button>
                    <span class="absolute top-1/2 -translate-y-1/2 left-12 font-semibold">$</span>
                    <input type="number" name="bid" id="bid-input"
                        class="w-full px-16 py-2 border rounded-md bg-slate-100 outline-none border-y-2 border-black"
                        value="{{ number_format($item->starting_bid, 2) }}">
                </div>
                <button class="px-8 py-2.5 bg-black text-white font-medium rounded-md" disabled>Bid</button>
            </form>
        </section>
    </div>
</div>
@endsection