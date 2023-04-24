@extends('layouts.admin')
@section('title', 'Add New Pharmacy')
@section('content')

<div class="conatiner-fluid mx-5">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Pharmacy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Pharmacy</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <form method="POST" action="{{route('pharmacy.store')}}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="mb-3 col-9">
            <label class="form-label">Pharmacy Name</label>
            <input type="text" name="name" class="form-control" @error('name') is-invalid @enderror"
                value="{{ old('name') }}" required autofocus>
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-9">
            <label class="form-label">Pharmacy Priority</label>
            <select class="form-control" name="priority" @error('priority') is-invalid @enderror"
                value="{{ old('priority') }}" required autofocus>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            @error('priority')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror

        </div>

        <div class="mb-3 col-9">
            <label class="form-label">Area</label>
            <select class="form-control" name="area_id" @error('area_id') is-invalid @enderror"
                value="{{ old('area_id') }}" required autofocus>
                @foreach($areas as $area)
                <option value="{{$area->id}}">{{$area->name}}</option>
                @endforeach
            </select>
            @error('area_id')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-9">
            <label for="image">Pharmacy Image</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">image</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" name="avatar" required>
                    <label class="custom-file-label" for="image">Choose Image</label>
                </div>
            </div>
            @error('avatar')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>

</div>
@endsection
