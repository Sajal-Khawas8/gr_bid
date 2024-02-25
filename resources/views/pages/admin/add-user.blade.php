@extends('layouts.admin')

@section('main')
<div class="px-6">
    {{ Breadcrumbs::render('addUser') }}
</div>
<x-shared.form.add-user-form title="Add New User" action="/dashboard/users/addUser" :$locations />

@endsection