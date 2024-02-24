@extends("layouts.admin")

@section("main")

<x-shared.form.update-user-form title="Update User Info" action="/dashboard/users/updateUser/{{ $user->uuid }}"
    :$user :$locations />

@endsection