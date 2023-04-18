@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add a New Doctor</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('doctor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="form-control-file @error('image') is-invalid @enderror">
                            @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="national_id">National ID</label>
                            <input type="text" id="national_id" name="national_id" class="form-control @error('national_id') is-invalid @enderror" value="{{ old('national_id') }}" required>
                            @error('national_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pharmacy_id">Pharmacy</label>
                            <select id="pharmacy_id" name="pharmacy_id" class="form-control @error('pharmacy_id') is-invalid @enderror" required>
                                <option value="">Select a Pharmacy</option>
                                @foreach($pharmacies as $pharmacy)
                                    <option value="{{ $pharmacy->id }}" {{ old('pharmacy_id') == $pharmacy->id ? 'selected' : '' }}>{{ $pharmacy->name }}</option>
                                @endforeach
                            </select>
                            @error('pharmacy_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
