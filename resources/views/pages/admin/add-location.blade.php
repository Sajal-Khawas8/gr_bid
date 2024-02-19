@extends("layouts.admin")

@section("main")
<article class="py-6 space-y-8">
    <h1 class="text-center text-4xl font-semibold">Add New Location</h1>
    <form action="/dashboard/locations/addLocation" method="post" class="space-y-8 max-w-md mx-auto">
        @csrf
        <x-shared.form.input name="location" placeholder="Location Name" />
        <x-shared.form.error name="location" />
        <x-shared.form.submit-button> Add Location </x-shared.form.submit-button>
    </form>
</article>

@endsection