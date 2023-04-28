@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <a href="{{ route('order.create') }}" class="btn btn-success" id="create-medicine"><i
                            class="fas fa-plus"></i> Add a New Order</a>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <table id="medicine-table" class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>is insured</th>
                    <th>Pharmacy</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Create At</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#medicine-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('order.index') }}",
            columns: [
                {data: 'id'},
                {data: 'user.name'},
                {data: 'is_insured'},
                {data: 'pharmacy.name'},
                {data: 'total_amount'},
                {data: 'status'},
                {
                    data: 'created_at', render: function (data, type, full, meta) {
                        return new Date(data).toLocaleDateString();
                    }
                },
                {
                    data: 'id', orderable: false, searchable: false,
                    render: function (data, type, full, meta) {
                        return `
                        <a class="btn btn-info btn-sm" href="{{route('medicine.edit',':id')}}">
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
    </script>
    <script>
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
                        url: '{{ route('order.index') }}/' + id,
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
