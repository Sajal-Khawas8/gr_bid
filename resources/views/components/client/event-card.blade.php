<figure class="h-full rounded-md bg-slate-100 relative cursor-pointer">
    <a href="/eventDetails/{{ $event->id }}" class="absolute inset-0 peer" aria-label="Event Name"></a>
    <div class="md:h-[calc(100%-5rem-2rem)] w-full peer-hover:bg-gray-300 rounded-t-md">
        <img src="{{ Storage::url($event->cover) }}" alt="{{ $event->name }}" class="w-full h-full object-contain">
    </div>
    <figcaption class="px-6 py-4 space-y-4 md:h-20">
        <h3 class="text-xl font-medium">{{ $event->name }}</h3>
        <dl class="flex md:items-center justify-between flex-col md:flex-row">
            <div class="flex flex-col sm:flex-row gap-2">
                <dt class="font-medium">Start of Event:</dt>
                <dd>{{ $event->start }}</dd>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <dt class="font-medium">End of Event:</dt>
                <dd>{{ $event->end }}</dd>
            </div>
        </dl>
    </figcaption>
</figure>