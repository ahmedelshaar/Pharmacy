@extends('layouts.admin')

@section('content')
<div class="card">
        <div class="card-header">
            <h3 class="card-title">Add a New Area</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('areas.store') }}" method="POST">
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
                            <label for="country_id">Country_id</label>
                            <input type="text" id="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror" value="{{ old('country_id') }}" required>
                            @error('country_id')
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