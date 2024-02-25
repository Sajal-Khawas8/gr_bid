@extends("layouts.main")

@section("main")
<x-shared.form.add-user-form title="Register" action="{{ route('register') }}" />
@endsection