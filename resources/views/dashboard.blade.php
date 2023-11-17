@extends('main')
@section('content')
<div class="card">
    <div class="card-header">Dashboard</div>
    <div class="card-body">You are login</div>
    <a href="{{route('logout')}}">logout</a>
</div>
@endsection('content')