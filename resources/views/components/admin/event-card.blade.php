<article class="flex items-center flex-wrap gap-10 h-32 bg-white px-6 py-4 rounded-md relative">
    <div class="h-full w-24">
        <img src="{{ Storage::url($event->cover) }}" alt="{{ $event->name }}" class="h-full w-full object-fill">
    </div>
    <div class="flex flex-col justify-between h-full">
        <h2 class="text-2xl font-semibold">{{ $event->name }}</h2>
        <h3 class="text-lg font-semibold">{{ $event->venue }}</h3>
        <dl class="grid grid-cols-2 lg:grid-cols-4 items-center gap-6">
            <div class="flex gap-2">
                <dt class="font-medium">Start:</dt>
                <dd>{{ $event->start }}</dd>
            </div>
            <div class="flex gap-2">
                <dt class="font-medium">End:</dt>
                <dd>{{ $event->end }}</dd>
            </div>
            <div class="col-span-2 flex flex-wrap gap-2 items-center">
                <dt class="font-medium">Total Items:</dt>
                <dd class="flex gap-10 items-center">
                    <p>3</p>
                    <x-shared.button onclick="document.getElementById('modal-{{ $event->id }}').style.display='flex'">
                        View Event Items</x-shared.button>
                </dd>
            </div>
        </dl>
    </div>
    <div class="flex flex-col justify-evenly h-full ml-auto">
        <x-shared.anchor-button href="/dashboard/events/updateEvent/{{ $event->id }}">
            Edit Event Info
        </x-shared.anchor-button>
        <form action="/dashboard/events/deleteEvent/{{ $event->id }}" method="post">
            @csrf
            @method("DELETE")
            <x-shared.button type="danger"
                onclick="document.getElementById('deleteModal-{{ $event->id }}').style.display='flex'">
                Delete Event</x-shared.button>
            <div id="deleteModal-{{ $event->id }}"
                class="absolute inset-0 bg-gray-500/60 hidden flex-col justify-center items-center space-y-8">
                <div class="flex gap-16 items-center">
                    <p class="font-semibold text-3xl">Are you sure?</p>
                    <x-shared.button class="!w-fit bg-transparent hover:bg-transparent !text-black"
                        onclick="document.getElementById('deleteModal-{{ $event->id }}').style.display='none'">
                        <x-icons.close class="w-7 h-7" />
                    </x-shared.button>
                </div>
                <div class="flex gap-16 items-center w-72">
                    <x-shared.form.submit-button class="bg-white !text-red-600 hover:bg-red-600 hover:!text-white">
                        Yes
                    </x-shared.form.submit-button>
                    <x-shared.button class="bg-white hover:bg-white !text-black !w-fit"
                        onclick="document.getElementById('deleteModal-{{ $event->id }}').style.display='none'">
                        Cancel
                    </x-shared.button>
                </div>
            </div>
        </form>
    </div>
</article>
<div id="modal-{{ $event->id }}"
    class="absolute inset-0 z-50 bg-gray-200/90 justify-center px-6 py-4 items-center hidden">
    <article class="space-y-4 flex flex-col">
        <div class="relative">
            <h2 class="font-semibold text-2xl text-center">Items in {{ $event->name }}</h2>
            <x-shared.anchor-button href="/dashboard/events/downloadItems/{{ $event->id }}" class="absolute top-0 right-0 !w-fit">
                Export
            </x-shared.anchor-button>
        </div>
        <div class="flex-1 flex items-center justify-center overflow-auto">
            <table class="text-center border border-b-2 border-gray-800 border-separate border-spacing-0">
                <thead class="sticky top-0 bg-indigo-500 text-white">
                    <tr>
                        <th class="border-2 border-r border-gray-800 px-1">S. No.</th>
                        <th class="border-x border-y-2 border-gray-800 px-1 w-40">Name</th>
                        <th class="border-x border-y-2 border-gray-800 px-1 w-40">Category</th>
                        <th class="border-x border-y-2 border-gray-800 px-1 w-40">Condition</th>
                        <th class="border-x border-y-2 border-gray-800 px-1 w-52">Description
                        </th>
                        <th class="border-x border-y-2 border-gray-800 px-2">Starting Bid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->items as $product)
                    <tr class="odd:bg-indigo-200 even:bg-indigo-300">
                        <td class="border border-l-2 border-gray-800 p-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-800 p-2">{{ $product->name }}</td>
                        <td class="border border-gray-800 p-2">{{ $product->category }}</td>
                        <td class="border border-gray-800 p-2">{{ $product->condition }}</td>
                        <td class="border border-gray-800 p-2 max-w-96 truncate">{{ $product->description }}</td>
                        <td class="border border-gray-800 p-2">${{ number_format($product->starting_bid, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
    <button type="button" class="absolute top-4 right-7"
        onclick="document.getElementById('modal-{{ $event->id }}').style.display='none'">
        <x-icons.close-circle class="w-8 h-8" />
    </button>
</div>