@extends("layouts.admin")

@section("main")
<div class="px-6">
    {{ Breadcrumbs::render('editUser', $user) }}
</div>
<x-shared.form.update-user-form title="Update User Info" action="/dashboard/users/updateUser/{{ $user->uuid }}"
    :$user :$locations />

@endsection