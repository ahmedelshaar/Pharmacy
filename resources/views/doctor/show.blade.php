@extends('layouts.admin')

@section('title')
    Show Doctor: {{ $doctor->name }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Show Doctor: {{ $doctor->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.index') }}">Doctor</a></li>
                        <li class="breadcrumb-item active">{{ $doctor->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name"
                                   class="form-control"
                                   value="{{$doctor['name'] }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image" class="d-block">image</label>
                            <img src="{{ asset($doctor['image']) }}" style="height: 250px; width: 250px; object-fit: cover" alt="{{ $doctor['name'] }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email"
                                   class="form-control" readonly
                                   value="{{ $doctor['email'] }}">
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="national_id">National ID</label>
                            <input type="number" id="national_id" name="national_id"
                                   class="form-control" value="{{ $doctor['national_id'] }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pharmacy_id">Pharmacy</label>
                            <input type="text" id="pharmacy_id" class="form-control" readonly value="{{ $doctor->pharmacy->name }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" onclick="return false;" id="is_banned" type="checkbox" value="1" name="is_banned" @if($doctor->is_banned) checked @endif>
                                <label class="form-check-label" for="is_banned">
                                    Banned
                                </label>
                            </div>
                            @error('is_banned')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
        </div>
        </div>
    </div>
@endsection
