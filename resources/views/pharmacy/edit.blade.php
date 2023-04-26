@extends('layouts.admin')

@section('title', 'Edit Pharmacy')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Pharmacy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pharmacy.index') }}">Pharmacy</a></li>
                        <li class="breadcrumb-item active">{{ $pharmacy->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{route('pharmacy.update', $pharmacy->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $pharmacy->name) }}"
                                   class="form-control @error('name') is-invalid @enderror" required autofocus>
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select id="priority" class="form-control @error('priority') is-invalid @enderror"
                                    name="priority" required>
                                <option selected>Choose...</option>
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{$i}}" {{ old('priority', $pharmacy->priority) == $i ? 'selected' : '' }}>{{$i}}</option>
                                @endfor
                            </select>
                            @error('priority')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="area">Area</label>
                        <select class="form-control @error('area_id') is-invalid @enderror" id="area" name="area_id"
                                required autofocus>
                            @foreach($areas as $area)
                                <option
                                    value="{{$area->id}}" {{ old('area_id', $pharmacy->area_id) == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                            @endforeach
                        </select>
                        @error('area_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="image">Image</label>
                        <div class="input-group mb-3 @error('avatar') is-invalid @enderror">
                            <div class="input-group-prepend">
                                <span class="input-group-text">image</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror"
                                       id="image" name="avatar" required>
                                <label class="custom-file-label" for="image">Choose Image</label>
                            </div>
                        </div>
                        @error('avatar')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 my-3">
                        <hr/>
                        <h3 class="text-center">Owner Information</h3>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="doctor_name"
                                   class="form-control @error('doctor_name') is-invalid @enderror" value="{{ old('doctor_name', $pharmacy->owner->name) }}"
                                   required autofocus>
                            @error('doctor_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $pharmacy->owner->email) }}"
                                   required>
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                            <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                            @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Password confirm</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror" required/>
                            @error('password_confirmation')
                            <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">image</label>
                            <div class="input-group mb-3 @error('image') is-invalid @enderror">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Image</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                           id="image" name="image" required>
                                    <label class="custom-file-label" for="image">Choose Image</label>
                                </div>
                            </div>
                            @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="national_id">National ID</label>
                            <input type="number" id="national_id" name="national_id"
                                   class="form-control @error('national_id') is-invalid @enderror"
                                   value="{{ old('national_id', $pharmacy->owner->national_id) }}" required>
                            @error('national_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
@endsection
