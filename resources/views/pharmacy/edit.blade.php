@extends('layouts.admin')
@section('title', 'Edit Pharmacy')
@section('content')

    <div class="conatiner-fluid mx-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Pharmacy</h1>
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
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error )
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('pharmacy.update', $pharmacy) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3 col-9">
                <label class="form-label">Pharmacy Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $pharmacy['name']) }}" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="priority">Pharmacy Priority</label>
                    <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror" required>
                        <option selected="">Select a Pharmacy</option>
                        <option value="1" @if($pharmacy->priority == 1) selected @endif>1</option>
                        <option value="2" @if($pharmacy->priority == 2) selected @endif>2</option>
                        <option value="3" @if($pharmacy->priority == 3) selected @endif>3</option>
                        <option value="4" @if($pharmacy->priority == 4) selected @endif>4</option>
                        <option value="5" @if($pharmacy->priority == 5) selected @endif>5</option>
                    </select>
                    @error('priority')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 col-9">
                <label class="form-label">Area</label>
                <select class="form-control @error('area_id') is-invalid @enderror" name="area_id"
                    value="{{ old('area_id', $pharmacy['area_id']) }}" required autofocus>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
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
                        <input type="file" class="custom-file-input" id="image" name="avatar">
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
