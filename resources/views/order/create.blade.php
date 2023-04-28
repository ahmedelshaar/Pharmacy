@extends('layouts.admin')

@section('title', 'Create Medicine')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Medicine</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create Medicine</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('medicine.store') }}" id="addNewMedicine" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror" required autofocus>
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" step="any" value="{{ old('price') }}"
                                   class="form-control @error('price') is-invalid @enderror" required>
                            @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="number" id="cost" name="cost" step="any" value="{{ old('price') }}"
                                   class="form-control @error('cost') is-invalid @enderror" required>
                            @error('cost')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
