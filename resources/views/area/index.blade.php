@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Areas</h3>
                    <div class="card-tools">
                        <a href="{{ route('area.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a
                            New Area</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table mt-4" id="area-table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Country</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Show</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#area-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('area.index') }}",
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'country.name'},
                {
                    data: 'created_at', render: function (data, type, full, meta) {
                        return new Date(data).toLocaleDateString();
                    }
                },
                {
                    data: 'id',
                    name: 'edit',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('area.edit', ':id') }}" class="btn btn-primary btn-sm">Edit</a>'.replace(':id', data);
                    }
                },
                {
                    data: 'id',
                    name: 'delete',
                    render: function (data, type, full, meta) {
                        return '<form action="{{ route('area.destroy', ':id') }}" method="POST" onsubmit="return confirm(\'Are you sure?\')"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="btn btn-danger btn-sm">Delete</button></form>'.replace(':id', data);
                    }
                },
                {
                    data: 'id',
                    name: 'show',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('area.show', ':id') }}" class="btn btn-success btn-sm">Show</a>'.replace(':id', data);
                    }
                }
            ]
        });
    </script>
@endsection
