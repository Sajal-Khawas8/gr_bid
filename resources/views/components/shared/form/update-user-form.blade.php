<article class="py-6 space-y-8 overflow-y-auto">
    <h1 class="text-center text-4xl font-semibold"> {{ $title }} </h1>
    <form action="{{ $action }}" method="post" enctype="multipart/form-data" class="space-y-8 max-w-md mx-auto">
        @csrf
        @method("PUT")
        <div>
            <x-shared.form.input name="name" placeholder="Full Name" :value="old('name', $user->name)" />
            <x-shared.form.error name="name" />
        </div>
        <div class="grid grid-cols-5 gap-8">
            <div class="col-span-3">
                <x-shared.form.input type="email" name="email" placeholder="Email Address"
                    :value="old('email', $user->email)" />
                <x-shared.form.error name="email" />
            </div>
            <div class="col-span-2">
                @php
                $options=['manager', 'employee'];
                @endphp
                <x-shared.form.select name="role" label="Select Role" :$options
                    :dataToMatch="$user->roles->first()->name" />
                <x-shared.form.error name="role" />
            </div>
        </div>

        <div>
            <div class="flex items-center gap-3">
                <label for="profilePicture">Choose Profile Picture: </label>
                <x-shared.form.file-input name="profilePicture" />
                <x-shared.button class="!w-fit px-0 bg-transparent hover:bg-transparent" title="View Uploaded Image"
                    onclick="document.getElementById('imageModal').classList.add('!flex')">
                    <x-icons.eye class="w-7 h-7 text-violet-700" />
                </x-shared.button>
                <section id="imageModal" class="hidden absolute inset-0 bg-gray-300/70 items-center justify-center">
                    <div class="relative w-96 bg-white py-4 space-y-2">
                        <h3 class="text-xl font-semibold text-center">Uploaded Image</h3>
                        <x-shared.button class="absolute top-0.5 right-2 !w-fit bg-transparent hover:bg-transparent"
                            onclick="document.getElementById('imageModal').classList.remove('!flex')">
                            <x-icons.close-circle class="w-6 h-6 text-black" />
                        </x-shared.button>
                        @empty($user->image)
                        <div class="flex gap-6 items-center px-4 py-3">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true" class="h-6 w-6 text-yellow-400">
                                    <path fill-rule="evenodd"
                                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="font-medium">You have not uploaded your profile picture!</p>
                        </div>
                        @else
                        <div class="py-4">
                            <img src="{{ Storage::url($user->image->url) }}" alt="{{ $user->name }}"
                                class="w-52 h-52 mx-auto">
                        </div>
                        @endempty
                    </div>
                </section>
            </div>
            <x-shared.form.error name="profilePicture" />
        </div>
        <div>
            <x-shared.form.text-area name="address" placeholder="Address">{{ old('address', $user->address) }}
            </x-shared.form.text-area>
            <x-shared.form.error name="address" />
        </div>
        @if (auth()->user()->hasRole('admin') && auth()->user()->id !== $user->id)
        <div>
            <div class="flex gap-2 items-center">
                <label for="locations">Select Locations (You can select more than one):</label>
                <select name="locations[]" class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600 [&>*]:p-0.5" multiple size="1">
                    @foreach ($locations->pluck('name') as $location)
                    <option value="{{ $location }}" @selected(old('locations') ? in_array($location, old('locations')) : in_array($location, $user->locations->pluck('location_name')->toArray()))>
                        {{ $location }}</option>
                    @endforeach
                </select>
            </div>
            <x-shared.form.error name="locations" />
            <x-shared.form.error name="locations.*" />
        </div>
        @else
        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-shared.form.input type="password" name="current_password" placeholder="Current Password" />
                <x-shared.form.error name="current_password" />
            </div>
            <div>
                <x-shared.form.input type="password" name="password" placeholder="New Password" />
                <x-shared.form.error name="password" />
            </div>
        </div>
        @endif
        <x-shared.form.submit-button> Update </x-shared.form.submit-button>
    </form>
</article>