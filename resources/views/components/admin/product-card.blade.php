<article class="flex flex-wrap gap-4 items-center px-4 py-2 rounded-md shadow-md bg-white">
    <div class="w-24 h-24 bg-slate-100">
        <img src="{{ Storage::url($product->images->first()->url) }}" alt="" class="w-full h-full object-contain">
    </div>
    <div class="flex-1 space-y-2">
        <h2 class="font-semibold text-xl flex justify-between">{{ $product->name }}<span
                class="text-gray-500 text-lg">#{{ $product->id }}</span></h2>
        <div class="flex justify-between gap-4">
            <dl class="flex flex-col justify-between">
                <div class="flex gap-2">
                    <dt class="font-medium">Condition:</dt>
                    <dd>{{ $product->condition }} {{ $product->old_months ? "(".$product->old_months . " M)" : "" }}</dd>
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
            <div class="space-y-4">
                <x-shared.anchor-button class="!px-1 !w-fit" href="/dashboard/inventory/updateItem/{{ $product->id }}">
                    <x-icons.edit class="w-6 h-6" />
                </x-shared.anchor-button>
                <form action="/dashboard/inventory/deleteItem/{{ $product->id }}" method="post">
                    @csrf
                    @method("DELETE")
                    <x-shared.form.submit-button class="bg-red-500 hover:bg-red-600 text-white rounded-md !px-1 !w-fit">
                        <x-icons.delete class="w-6 h-6" />
                    </x-shared.form.submit-button>
                </form>
            </div>
        </div>
    </div>
</article>