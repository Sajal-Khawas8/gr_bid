<article {{ $attributes->merge(["class" => "py-6 space-y-8 overflow-y-auto"]) }}>
    <h1 class="text-center text-4xl font-semibold"> {{ $title }} </h1>
    <form action="{{ $action }}" method="post" enctype="multipart/form-data" class="space-y-8 max-w-md mx-auto">
        @csrf
        <div>
            <x-shared.form.input name="name" placeholder="Full Name" />
            <x-shared.form.error name="name" />
        </div>
        <div>
            <x-shared.form.input type="email" name="email" placeholder="Email Address" />
            <x-shared.form.error name="email" />
        </div>
        <div>
            <div class="flex items-center gap-3">
                <label for="profilePicture">Choose Profile Picture: </label>
                <x-shared.form.file-input name="profilePicture" />
            </div>
            <x-shared.form.error name="profilePicture" />
        </div>
        @role('admin')
        <div>
            <fieldset class="space-y-3">
                <legend>Choose Locations:</legend>
                <div class="flex gap-4 flex-wrap">
                    @foreach ($locations as $location)
                    <label class="flex items-center justify-center gap-2 cursor-pointer">
                        <input type="checkbox" name="locations[]" class="w-4 h-4 rounded-md accent-indigo-600"
                            @checked(old('locations') && in_array($location->name, old('locations')))
                        value="{{ $location->name }}"> {{ $location->name }}
                    </label>
                    @endforeach
                </div>
                <x-shared.form.error name="locations" />
                <x-shared.form.error name="locations.*" />

            </fieldset>
        </div>
        @endrole
        <div>
            <x-shared.form.text-area name="address" placeholder="Address" />
            <x-shared.form.error name="address" />
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-shared.form.input type="password" name="password" placeholder="Password" />
                <x-shared.form.error name="password" />
            </div>
            <div>
                <x-shared.form.input type="password" name="password_confirmation" placeholder="Confirm Password" />
                <x-shared.form.error name="password" />
            </div>
        </div>
        <x-shared.form.submit-button> Register </x-shared.form.submit-button>
    </form>
</article>