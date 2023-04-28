@extends('layouts.admin')

@section('title', 'Edit medicine: ' . $medicine->name)

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit medicine: {{ $medicine->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('medicine.index') }}">Medicine</a></li>
                        <li class="breadcrumb-item active">{{ $medicine->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('medicine.update', $medicine->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $medicine->name) }}">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="any"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $medicine->price) }}">
                    @error('price')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" id="cost" step="any" name="cost" class="form-control @error('cost') is-invalid @enderror"
                           value="{{ old('cost', $medicine->cost) }}">
                    @error('cost')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
