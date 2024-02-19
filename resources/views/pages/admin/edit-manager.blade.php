@extends("layouts.admin")

@section("main")

<x-shared.form.update-user-form title="Update Manager Info" action="/dashboard/managers/updateManager/{{ $user->uuid }}"
    :$user :$locations />

@endsection