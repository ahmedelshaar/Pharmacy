@extends('layouts.admin')
@section('title', 'All Area')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Areas</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <a href="{{ route('area.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a New
                        Area</a>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <table class="table mt-4" id="area-table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
            </table>
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
                    data: 'id', orderable: false, searchable: false,
                    render: function (data, type, full, meta) {
                        return `
                        <a href="{{ route('area.show', ':id') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-eye"></i>
                        Show</a>
                        <a class="btn btn-info btn-sm" href="{{route('area.edit',':id')}}">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </a>
                        <button class="btn btn-danger btn-sm swal-delete" onclick="sweetDelete(event)"
                                data-id="{{ ':id' }}">
                            <i class="fas fa-trash-alt"></i> Delete
                            </button>`.replaceAll(':id', data);
                    },
                },
            ]
        });

        function sweetDelete(e) {
            e.preventDefault();

            const id = $(e.target).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('area.index') }}/' + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE'
                        },
                        success: function (data) {
                            $('table').DataTable().ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                'The record has been deleted.',
                                'success'
                            );
                        },
                        error: function (data) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the record.',
                                'error'
                            );
                        }
                    });

                }
            });
        }
    </script>
@endsection
