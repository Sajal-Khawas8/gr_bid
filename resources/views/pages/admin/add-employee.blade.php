@extends('layouts.admin')

@section('main')

<x-shared.form.add-user-form title="Add New Employee" action="/dashboard/employees/addEmployee" :$locations />

@endsection