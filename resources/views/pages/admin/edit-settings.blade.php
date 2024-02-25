@extends("layouts.admin")

@section("main")
<div class="px-6">
    {{ Breadcrumbs::render('editSettings') }}
</div>
<x-shared.form.update-user-form title="Update Your Info" action="/dashboard/settings/update" />

@endsection