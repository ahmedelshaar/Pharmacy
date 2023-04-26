@extends('layouts.admin')

@section('title')
    Show Pharmacy
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" style="height: 300px; object-fit: cover"
                         src="{{ asset($pharmacy->avatar) }}" alt="Pharmacy Image">
                    <h5 class="card-header">Pharmacy: {{$pharmacy->name}}</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Area: {{$pharmacy->area->name}}</li>
                        <li class="list-group-item">Priority: {{$pharmacy->priority}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" style="height: 300px; object-fit: cover"
                         src="{{ asset($pharmacy->owner->image) }}" alt="Owner Image">
                    <h5 class="card-header">Owner: {{$pharmacy->owner->name}}</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Email: {{$pharmacy->owner->email}}</li>
                        <li class="list-group-item">National ID: {{$pharmacy->owner->national_id}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Doctors</h1>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-end">
                                <a href="{{ route('doctor.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a New
                                    Doctor</a>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card">
                    <div class="card-body">
                        <table id="doctors-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Pharmacy</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        table = $('#doctors-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('doctor.index') }}",
                data: function (d) {
                    d.pharmacy_id = {{$pharmacy->id}}
                }
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {
                    data: 'pharmacy.name', name: 'pharmacy',
                    search: {
                        value: 'opdvk'
                    }
                },
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
                    data: 'id', orderable: false, searchable: false,
                    render: function (data, type, full, meta) {
                        return `
                        <a href="{{ route('doctor.show', ':id') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-eye"></i>
                        Show</a>
                        <a class="btn btn-info btn-sm" href="{{route('doctor.edit',':id')}}">
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
                        url: '{{ route('doctor.index') }}/' + id,
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
