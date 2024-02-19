<article class="flex justify-between">
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">{{ $location->name }}</h2>
        
    </div>
    @role('admin')
    <div class="space-y-4">
        <x-shared.anchor-button href="/dashboard/locations/updateLocation/{{ $location->name }}">
            <x-icons.edit class="w-6 h-6" />
        </x-shared.anchor-button>
        <form action="/dashboard/locations/deleteLocation/{{ $location->name }}" method="post">
            @csrf
            @method("DELETE")
            <x-shared.form.submit-button class="bg-red-500 hover:bg-red-600 text-white rounded-md">
                <x-icons.delete class="w-6 h-6" />
            </x-shared.form.submit-button>
        </form>
    </div>
    @endrole
</article>