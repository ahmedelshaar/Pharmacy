@extends('layouts.admin')

@section('title')
    All Pharmacies
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Doctors</h1>
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
            <table id="pharmacy-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Prority</th>
                    <th>Area</th>
                    <th>Avatar</th>
                    <th>Edit</th>
                    <th>Show</th>
                    <th>Delete</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#pharmacy-table').dataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('pharmacy.index') }}",
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'priority'},
                {data: 'area.name'},
                {
                    data: 'avatar',
                    name: 'image',
                    render: function (data, type, full, meta) {
                        {{--return '<img src="' + {{ asset('images/pharmacy/:image') }} + '" height="50"/>'.replace(':image', data);--}}
                            return '<img src="' + '{{ asset('') }}' + data + '" height="50"/>';
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
                    name: 'show',
                    render: function (data, type, full, meta) {
                        return '<a href="{{ route('pharmacy.show', ':id') }}" class="btn btn-success btn-sm">Show</a>'.replace(':id', data);
                    }
                },
                {
                    data: 'id',
                    name: 'delete',
                    render: function (data, type, full, meta) {
                        return '<form action="{{ route('pharmacy.destroy', ':id') }}" method="POST" onsubmit="return confirm(\'Are you sure?\')"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="btn btn-danger btn-sm">Delete</button></form>'.replace(':id', data);
                    }
                }
            ]
        });
    </script>
@endsection
