@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit medicine</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('medicine.update', $medicine->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $medicine->name }}">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" class="form-control" value="{{ $medicine->price }}">
                </div>

                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" name="cost" class="form-control" value="{{ $medicine->cost }}">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
