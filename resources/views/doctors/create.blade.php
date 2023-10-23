@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Create Doctor</h1>
                <hr>
                @include('partials.flash-message')
                <form method="POST" action="{{ route('doctors.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="national_id">National ID</label>
                        <input type="text" class="form-control" id="national_id" name="national_id" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Avatar Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="pharmacy_id">pharmacy_id</label>
                        <input type="text" class="form-control" id="pharmacy_id" name="pharmacy_id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Doctor</button>
                </form>
            </div>
        </div>
    </div>
@endsection
