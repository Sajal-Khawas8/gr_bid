@extends("layouts.main")

@section("main")
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-16 py-8 relative">
    <section class="col-span-2 h-fit space-y-10">
        <div class="h-[600px] aspect-square max-w-full my-5 mx-auto rounded-md bg-gray-300">
            <img src="{{ Storage::url($event->cover) }}" alt="{{ $event->name }}"
                class="h-full w-full object-fill rounded-md">
        </div>
        <div class="space-y-6">
            <h1 class="text-4xl font-bold">{{ $event->name }}</h1>
            <p>{{ $event->description }}</p>
        </div>
        <article class="border border-gray-200 py-6 pr-6 space-y-3">
            <h3 class="px-6 py-2 bg-slate-100 text-xl font-bold">Event Information</h3>
            <dl class="px-6 space-y-4">
                <div class="flex gap-2">
                    <dt class="text-lg font-medium">Auction Start:</dt>
                    <dd>{{ $event->start }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="text-lg font-medium">Auction End:</dt>
                    <dd>{{ $event->end }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="text-xl font-medium">Venue:</dt>
                    <dd class="text-xl font-medium text-blue-600">{{ $event->venue }}</dd>
                </div>
            </dl>
        </article>
        <article class="border border-gray-200 py-6 pr-6 space-y-3">
            <h3 class="px-6 py-2 bg-slate-100 text-xl font-bold">Vendor Information</h3>
            <dl class="px-6 flex items-center gap-2">
                <dt class="text-lg font-medium">Host:</dt>
                <dd>{{ $event->user->name }}</dd>
            </dl>
        </article>
    </section>
    <div class="relative">
        <section class="shadow-lg p-6 rounded-md h-fit sticky top-[128px] right-16 space-y-8">
            <h2 class="font-bold text-4xl">Items in Auction</h2>
            <ul class="space-y-5">
                @foreach ($event->items as $item)
                <li class="flex items-center gap-8 border rounded-md p-2">
                    <div class="h-24 w-24 border rounded-md bg-slate-200">
                        <img src="{{ Storage::url($item->images->first()->url) }}" alt="item" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1 space-y-3">
                        <h3 class="text-xl font-semibold">{{ $item->name }}</h3>
                        <dl class="flex gap-2">
                            <dt class="text-lg font-medium">Starting Bid:</dt>
                            <dd>${{ number_format($item->starting_bid, 2) }}</dd>
                        </dl>
                        <div class="text-right font-medium text-blue-500">
                            <a href="/itemDetails/{{ $item->id }}" class="inline-flex items-center gap-1">
                                <span>View Details</span>
                                <x-icons.right-arrow class="w-5 h-5" />
                            </a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </section>
    </div>
</div>
@endsection