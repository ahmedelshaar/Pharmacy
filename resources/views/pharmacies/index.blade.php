@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pharmacies</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Pharmacies</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <a class="btn btn-primary btn-sm ml-auto" href="{{ route('pharmacies.create') }}">
                            <i class="fas fa-plus"></i>
                             New Pharmacy
                        </a>
                    </h3>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 20%">Logo</th>
                            <th style="width: 20%">Priority</th>
                            <th style="width: 20%">Area</th>
                            <th style="width: 30%">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <script src={{ asset("https://cdn.jsdelivr.net/npm/sweetalert2@10")}}></script>
    <script>
        $('table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pharmacies.index') }}",
            columns: [
                {data: 'id'},
                {data: 'name'},
                {
                    data: 'avatar',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return '<img src="' + data + '" alt="' + full.name + '" width="50">';
                    }
                },
                {data: 'priority'},
                {data: 'area.name'},
                {
                    data: 'id', orderable: false, searchable: false,
                    render: function (data, type, full, meta) {
                        let restoreBtn = '<form method="POST" action="{{ route('pharmacies.restore', ':id') }}" class="d-inline">' +
                            '@csrf' +
                            '<button type="submit" class="btn btn-success rounded col-9">' +
                            '<i class="fas fa-undo"></i>' +
                            '</button>' +
                            '</form>';
                        let deleteBtn = '<form method="POST" action="{{ route('pharmacies.destroy', ':id') }}" class="d-inline">' +
                            '@csrf' +
                            '@method('delete')' +
                            '<button type="submit" class="btn btn-danger rounded col-4" onclick="sweetDelete(event)" data-id="{{ ':id' }}">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</form>';
                        let actionsTd = '<td class="project-actions text-right">';
                        if (full.deleted_at) {
                            actionsTd += restoreBtn.replaceAll(':id', data);
                        } else {
                            actionsTd += '<a class="btn btn-primary rounded mr-2 col-4" href="{{ url('pharmacy') }}/' + data + '/edit">' +
                                '<i class="fas fa-edit"></i>' +
                                '</a>';
                            actionsTd += '</td>';
                            actionsTd += '<td class="col">' + deleteBtn.replaceAll(':id', data) + '</td>';
                            actionsTd += '<td class="col"></td>';
                        }
                        return actionsTd;
                    }
                }
            ]
        });
    </script>
    <script>
        function sweetDelete(e) {
            e.preventDefault();
            const id = $(e.target).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this pharmacy?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/pharmacy/' + id,
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
