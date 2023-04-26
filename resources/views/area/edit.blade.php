@extends('layouts.admin')

@section('title', 'Edit Area: ' . $area->name)

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Area: {{ $area->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('area.index') }}">Area</a></li>
                        <li class="breadcrumb-item active">{{ $area->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('area.update', ['area' => $area->id]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ $area->name }}">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <select name="country_id" class="form-control @error('name') is-invalid @enderror">
                        <option value="">Select a country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                    @if(old('country_id', $area->country_id) == $country->id) selected @endif>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">update</button>
            </form>
        </div>
    </div>
@endsection
