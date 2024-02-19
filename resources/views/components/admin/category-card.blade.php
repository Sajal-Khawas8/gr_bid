<article class="flex justify-between">
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">{{ $category->name }}</h2>
        <dl class="flex gap-2">
            <dt class="font-medium">Total Items:</dt>
            <dd>{{ $category->items->count() }}</dd>
        </dl>
    </div>
    @role('admin')
    <div class="space-y-4">
        <x-shared.anchor-button href="/dashboard/categories/updateCategory/{{ $category->name }}">
            <x-icons.edit class="w-6 h-6" />
        </x-shared.anchor-button>
        <form action="/dashboard/categories/deleteCategory/{{ $category->name }}" method="post">
            @csrf
            @method("DELETE")
            <x-shared.form.submit-button class="bg-red-500 hover:bg-red-600 text-white rounded-md">
                <x-icons.delete class="w-6 h-6" />
            </x-shared.form.submit-button>
        </form>
    </div>
    @endrole
</article>