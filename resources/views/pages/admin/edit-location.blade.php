@extends("layouts.admin")

@section("main")
<div class="px-6">
    {{ Breadcrumbs::render('editLocation', $location) }}
</div>
<article class="py-6 space-y-8">
    <h1 class="text-center text-4xl font-semibold">Update Location</h1>
    <form action="/dashboard/locations/updateLocation/{{ $location->name }}" method="post"
        class="space-y-8 max-w-md mx-auto">
        @csrf
        @method("PATCH")
        <x-shared.form.input name="location" placeholder="Location Name" :value="old('location', $location->name)" />
        <x-shared.form.error name="location" />
        <x-shared.form.submit-button> Update Location </x-shared.form.submit-button>
    </form>
</article>

@endsection