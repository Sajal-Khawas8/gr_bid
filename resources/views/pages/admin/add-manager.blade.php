@extends('layouts.admin')

@section('main')

<x-shared.form.add-user-form title="Add New Manager" action="/dashboard/managers/addManager" :$locations />

@endsection