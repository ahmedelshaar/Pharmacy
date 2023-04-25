@extends('layouts.admin')

@section('title')
Show Pharmacy
@endsection

@section('content')
<div class="container">
<div class="card mt-4">
    <div class="card-header">
        Pharmacy Info
    </div>
    <div class="card-body">
        <h5 class="card-title">Pharmacy Name: {{$pharmacy['name']}}</h5>
        <p class="card-text">Priority: {{$pharmacy['priority']}}</p>
        <p class="card-text">Area: {{$pharmacy->area->name}}</p>
    </div>
</div>
@if ($pharmacy->avatar)
<div class="card mt-4 text-center">
    <div class="card-header">
        <h1>Pharmacy Image</h1>
    </div>
    <div class="card-body">
        <img src="{{ asset($pharmacy->avatar) }}" alt="Pharmacy Image" class="img-fluid">
    </div>
</div>
</div>
@endif

@endsection
