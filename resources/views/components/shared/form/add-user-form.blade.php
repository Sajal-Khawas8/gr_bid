<article {{ $attributes->merge(["class" => "py-6 space-y-8 overflow-y-auto"]) }}>
    <h1 class="text-center text-4xl font-semibold"> {{ $title }} </h1>
    <form action="{{ $action }}" method="post" enctype="multipart/form-data" class="space-y-8 max-w-md mx-auto">
        @csrf
        <div>
            <x-shared.form.input name="name" placeholder="Full Name" />
            <x-shared.form.error name="name" />
        </div>
        <div class="grid grid-cols-5 gap-8">
            <div class="col-span-3">
                <x-shared.form.input type="email" name="email" placeholder="Email Address" />
                <x-shared.form.error name="email" />
            </div>
            <div class="col-span-2">
                @php
                $options=['manager', 'employee'];
                @endphp
                <x-shared.form.select name="role" label="Select Role" :$options />
                <x-shared.form.error name="role" />
            </div>
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
            <div class="flex gap-2 items-center">
                <label for="locations">Select Locations (You can select more than one):</label>
                <select name="locations[]"
                    class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600 [&>*]:p-0.5" multiple
                    size="1">
                    @foreach ($locations->pluck('name') as $location)
                    <option value="{{ $location }}" @selected(old('locations') && in_array($location, old('locations')))>
                        {{ $location }}</option>
                    @endforeach
                </select>
            </div>
            <x-shared.form.error name="locations" />
            <x-shared.form.error name="locations.*" />
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