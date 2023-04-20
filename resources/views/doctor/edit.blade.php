@extends('layouts.admin')

@section('title')
    Create
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Doctor</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('doctor.update', $doctor) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $doctor['name'] }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control" value="{{ $doctor['email'] }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="{{ $doctor['password'] }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control-file"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="national_id">National ID</label>
                            <input type="text" name="national_id" class="form-control" value="{{ $doctor['national_id'] }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pharmacy_id">Pharmacy ID</label>
                            <select name="pharmacy_id" class="form-control">
                                <option selected="" disabled="">Select a Pharmacy</option>
                                @foreach($pharmacies as $pharmacy)
                                    <option value="{{$pharmacy->id}}" {{ old('pharmacy_id', $doctor->pharmacy_id) == $pharmacy->id ? 'selected' : '' }}>{{$pharmacy->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
@endsection
