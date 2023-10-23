@extends('layouts.admin')

@section('content')
    <section class="content mt-5">
        <div class="row">
            <div class="col-md-12">
                @include('partials.flash-message')
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">New order</h3>
                    </div>
                    <div class="card-body">
                        @include('partials.validation_errors')
                        <form action="{{ route('orders.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Type</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    @foreach($users as $user)
                                        <option
                                            value="{{ $user->id }}">{{ $user->name }}
                                        </option>
                                @endforeach
                            </div>
                            <div class="form-group">

                                <input type="checkbox" name="is_insured" value="1">
                                <label for="name">Is insured</label>
                            </div>
                            <input type="submit" value="Add" class="my-3 btn btn-success">

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
