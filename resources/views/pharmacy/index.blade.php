@extends('layouts.admin')

@section('title', 'Pharmacies')

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
            <table id="pharmacy-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Priority</th>
                    <th>Area</th>
                    <th>Avatar</th>
                    <th>Owner</th>
                    <th>Action</th>
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
                    orderable: false,
                    render: function (data, type, full, meta) {
                            return '<img src="' + '{{ asset('') }}' + data + '" height="50"/>';
                    }
                },
                {data: 'owner.name'},
                {
                    data: 'id', orderable: false, searchable: false,
                    render: function (data, type, full, meta) {
                        return `
                        <a href="{{ route('pharmacy.show', ':id') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-eye"></i>
                        Show</a>
                        <a class="btn btn-info btn-sm" href="{{route('pharmacy.edit',':id')}}">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </a>
                        <button class="btn btn-danger btn-sm swal-delete" onclick="sweetDelete(event)"
                                data-id="{{ ':id' }}">
                            <i class="fas fa-trash-alt"></i> Delete
                            </button>`.replaceAll(':id', data);
                    },
                }
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
                        url: '{{ route('pharmacy.index') }}/' + id,
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
