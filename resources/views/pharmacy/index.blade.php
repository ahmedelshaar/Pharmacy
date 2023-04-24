@extends('layouts.admin')

@section('title')
    All Pharmacies
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pharmacies</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <a href="{{ route('pharmacy.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a New
                        Pharmacy</a>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <table id="pharmacies-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Area</th>
                    <th>Priority</th>
                    <th>Image</th>
                    <th>Created At</th>
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
        $('#pharmacies-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pharmacy.index') }}",
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'area.name'},
                {data: 'priority'},
                {
                    data: 'image',
                    name: 'image',
                    render: function (data, type, full, meta) {
                        return '<img src="' + '{{ asset('') }}' + data + '" height="50"/>';
                    }
                },
                {
                    data: 'created_at', render: function (data, type, full, meta) {
                        return new Date(data).toLocaleDateString();
                    }
                },
                {
                    data: 'id',
                    name: 'edit',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('pharmacy.edit', ':id') }}" class="btn btn-primary btn-sm">Edit</a>'.replace(':id', data);
                    }
                },
                {
                    data: 'id',
                    name: 'delete',
                    render: function (data, type, full, meta) {
                        return '<form action="{{ route('pharmacy.destroy', ':id') }}" method="POST" onsubmit="return confirm(\'Are you sure?\')"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="btn btn-danger btn-sm">Delete</button></form>'.replace(':id', data);
                    }
                },
                {
                    data: 'id',
                    name: 'show',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('pharmacy.show', ':id') }}" class="btn btn-success btn-sm">Show</a>'.replace(':id', data);
                    }
                }
            ]
        });
    </script>
@endsection
