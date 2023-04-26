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
        <form method="POST" action="{{ route('area.update', ['area' => $area->id]) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $area->name }}">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Country</label>
                <select name="country_id" class="form-control @error('name') is-invalid @enderror">
                    <option value="" >Select a country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @if($area->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">update</button>
        </form>
        </div>
</div>
@endsection
