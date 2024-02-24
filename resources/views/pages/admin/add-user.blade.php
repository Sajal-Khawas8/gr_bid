@extends('layouts.admin')

@section('main')

<x-shared.form.add-user-form title="Add New User" action="/dashboard/users/addUser" :$locations />

@endsection