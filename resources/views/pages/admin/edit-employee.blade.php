@extends("layouts.admin")

@section("main")

<x-shared.form.update-user-form title="Update Employee Info"
    action="/dashboard/employees/updateEmployee/{{ $user->uuid }}" :$user :$locations />

@endsection