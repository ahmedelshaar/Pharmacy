@extends('layouts.admin')

@section('title')
    Show User: {{ $user->name }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $user->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name"
                               class="form-control"
                               value="{{$user['name'] }}" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image" class="d-block">image</label>
                        <img src="{{ asset($user['image']) }}" style="height: 250px; width: 250px; object-fit: cover"
                             alt="{{ $user['name'] }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email"
                               class="form-control" readonly
                               value="{{ $user['email'] }}">
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="national_id">National ID</label>
                        <input type="number" id="national_id" name="national_id"
                               class="form-control" value="{{ $user['national_id'] }}" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="pharmacy_id">Gender</label>
                        <input type="text" id="pharmacy_id" class="form-control" readonly
                               value="{{ $user->phone}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="pharmacy_id">Birth Date</label>
                        <input type="text" id="pharmacy_id" class="form-control" readonly
                               value="{{ $user->birth_date}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="pharmacy_id">Gender</label>
                        <input type="text" id="pharmacy_id" class="form-control" readonly
                               value="{{ $user->gender}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="pharmacy_id">Last Login</label>
                        <input type="text" id="pharmacy_id" class="form-control" readonly
                               value="{{ $user->last_login}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="pharmacy_id">Verified At</label>
                        <input type="text" id="pharmacy_id" class="form-control" readonly
                               value="{{ $user->email_verified_at ?? 'Not Verified'}}">
                    </div>
                </div>


            </div>
        </div>
    </div>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$user->name}} Addresses</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <a href="{{ route('doctor.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a New
                        Address</a>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <table id="addresses-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Area Name</th>
                    <th>Street Name</th>
                    <th>Building Number</th>
                    <th>Floor Number</th>
                    <th>Flat Number</th>
                    <th>Is Main</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Show</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#addresses-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.show',$user->id) }}",
            columns: [
                {data: 'id'},
                {data: 'area.name'},
                {data: 'street_name'},
                {data: 'building_number'},
                {data: 'floor_number'},
                {data: 'flat_number'},
                {data: 'is_main'},
                {
                    data: 'id',
                    name: 'edit',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('user.edit', ':id') }}" class="btn btn-primary btn-sm">Edit</a>'.replace(':id', data);
                    }
                },
                {
                    data: 'id',
                    name: 'delete',
                    render: function (data, type, full, meta) {
                        return '<form action="{{ route('user.destroy', ':id') }}" method="POST" onsubmit="return confirm(\'Are you sure?\')"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="btn btn-danger btn-sm">Delete</button></form>'.replace(':id', data);
                    }
                },
                {
                    data: 'id',
                    name: 'show',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('user.show', ':id') }}" class="btn btn-success btn-sm">Show</a>'.replace(':id', data);
                    }
                }
            ]
        });
    </script>
@endsection

