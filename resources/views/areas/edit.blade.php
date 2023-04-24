@extends('layouts.admin')

@section('title')
    Create
@endsection

@section('content')
<div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Area</h3>
        </div>
        <div class="card-body">
        <form method="POST" action="{{ route('areas.update', ['area' => $area->id]) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $area->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Country_id</label>
                <input type="text" name="country_id" class="form-control" value="{{ $area->country_id }}">
            </div>

            <button type="submit" class="btn btn-success">update</button>
        </form>
        </div>
</div>
@endsection
