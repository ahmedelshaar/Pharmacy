@extends('layouts.admin')

@section('title')
    All Users
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <a href="{{ route('user.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a New
                        User</a>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <table id="users-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Image</th>
                    <th>Last Login</th>
                    <th>Show</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#users-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.index') }}",
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'gender'},
                {
                    data: 'image',
                    name: 'image',
                    render: function (data, type, full, meta) {
                        return '<img src="' + '{{ asset('') }}' + data + '" height="50"/>';
                    }
                },
                {
                    data: 'last_login',
                    render: function (data, type, full, meta) {
                        return new Date(data).toLocaleDateString();
                    }
                },
                {
                    data: 'id',
                    name: 'show',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('user.show', ':id') }}" class="btn btn-success btn-sm">Show</a>'.replace(':id', data);
                    }
                },
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
                }
            ]
        });
    </script>
@endsection
