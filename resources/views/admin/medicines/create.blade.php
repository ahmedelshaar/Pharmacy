@extends('layouts.admin')

@section('content')
    <section class="content mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">New Medicine</h3>
                    </div>
                    <div class="card-body">
                        @include('partials.validation_errors')
                        <form action="{{ route('medicines.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Price</label>
                                <input type="number" id="price" name="price" min="1" value="{{ old('price') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Type</label>
                                {{--                                <input type="number" id="cost" name="cost" min="1" value="{{ $medicine->cost }}" class="form-control"> --}}
                                <select name="type_id" id="type_id" class="form-control">
                                    @foreach($types as $type)
                                        <option
                                            value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach

                            </div>

                            <input type="submit" value="Add" class="btn btn-success">
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
