@extends("layouts.admin")

@section("main")
<section class="py-8 space-y-10">
    <h1 class="text-center text-4xl font-semibold">Account Settings</h1>
    <x-shared.settings update="/dashboard/settings/update" delete="/dashboard/settings/delete" />
</section>
@endsection