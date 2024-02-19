<article class="flex justify-between gap-6">
    <div class="flex-1 flex items-center gap-4">
        @empty ($user->image)
        <div class="w-32 h-32 rounded-md bg-gray-600 flex items-center justify-center">
            <x-icons.user class="w-full h-full text-slate-100" />
        </div>
        @else
        <div class="w-32 h-32 rounded-md">
            <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}"
                class="h-full w-full object-cover rounded-md">
        </div>
        @endif
        <div class="space-y-1">
            <h2 class="font-semibold text-2xl">{{ $user->name }}</h2>
            <p class="font-medium text-lg"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
            </p>
            <dl class="max-w-44">
                <div>
                    <dt class="font-medium">Address:</dt>
                    <dd>
                        <address class="not-italic truncate">{{ $user->address }}</address>
                    </dd>
                </div>
                <div>
                    <dt class="font-medium">Working At:</dt>
                    <dd class="flex gap-1">
                        @foreach ($user->locations as $location)
                        <address class="not-italic [&:not(:last-child)]:after:content-[',']">{{ $location->location_name }}</address>
                        @endforeach
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    @role("admin")
    <div class="space-y-4">
        <x-shared.anchor-button href="{{ $updateAction }}" class="!px-2">
            <x-icons.edit class="w-6 h-6" />
        </x-shared.anchor-button>
        <form action="{{ $deleteAction }}" method="post">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id" value="{{ $user->uuid }}">
            <x-shared.form.submit-button class="bg-red-500 hover:bg-red-600 rounded-md !px-2">
                <x-icons.delete class="w-6 h-6" />
            </x-shared.form.submit-button>
        </form>
    </div>
    @endrole

</article>