@extends('layouts.admin')

@section('content')
    <section class="content mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Area</h3>
                        </div>
                        <div class="card-body">
                            @include('partials.validation_errors')
                            <form action="{{ route('areas.update', $area->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Area Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name')? old('name'): $area->name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="country_id">Country</label>
                                    <select id="country_id" name="country_id" class="form-control custom-select">
                                        <option selected="" disabled="">Select one</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{ $country->id == $area->country_id ? 'selected' : ($country->id == old('country_id') ? 'selected' : '') }}>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="submit" value="Edit Area" class="btn btn-success">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
@endsection
