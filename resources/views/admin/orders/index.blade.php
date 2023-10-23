@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" href="{{route('orders.index')}}">Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('partials.flash-message')
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-primary btn-sm" href="{{ route('orders.create') }}">
                        <i class="fas fa-plus">
                        </i>
                        New Order
                    </a>
                </h3>

            </div>
            <div class="card-body p-3">
                <table id="table" class="table table-striped table-borderless  text-center">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 30%">
                            User Name
                        </th>
                        <th style="">
                            Delivering Address
                        </th>
                        <th style="width: 20%">
                            Creation Date
                        </th>
                        <th style="">
                            Doctor Name
                        </th>
                        @role('admin')
                        <th style="">
                            Pharmacy Name
                        </th>
                        <th style="">
                            Creator Type
                        </th>
                        @endrole
                        <th style="">
                            Is Insured
                        </th>
                        <th style="">
                            Status
                        </th>
                        <th style="width: 30%">
                            Actions
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <script src={{ asset("https://cdn.jsdelivr.net/npm/sweetalert2@10")}}></script>
    <script>
        $('table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders.index') }}",
            columns: [
                {data: 'id'},
                {data: 'user.name'},
                {data: 'delivering_address.street_name'},
                {data: (data) => new Date(data.created_at).toLocaleString('en-EG')},
                {data: (data) => data.doctor ? data.doctor.name : 'N/A'},
            @role('admin')
                {data: (data) => data.pharmacy ? data.pharmacy.name : 'N/A'},
                {data: 'creation_type'},
            @endrole
                {data: 'is_insured'},
                {data: 'status',},

                {
                    data: 'id', orderable: false, searchable: false,
                    render: function (data, type, full, meta) {

                        return `
                        <a class="btn btn-info btn-sm" href="{{route('orders.edit',':id')}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Process
                        </a>
                        <button class="btn btn-danger btn-sm ${!["New", 'Processing'].includes(full.status) ? 'd-none' : ''}" onclick="sweetDelete(event)"
                                data-id="{{ ':id' }}">
                            <i class="fas fa-trash-alt"></i> Cancel
                            </button>`.replaceAll(':id', data);


                    },
                }
            ]
        })
        ;
    </script>
    <script>
        // Handle the SweetAlert confirmation dialog for delete actions
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


                    // Send the delete request
                    $.ajax({
                        type: 'POST',
                        url: '/orders/' + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE'
                        },
                        success: function (data) {
                            // console.log(data);
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

        // $('.swal-delete').click(sweetDelete);
    </script>
@endsection
