@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Doctors</h1>
                <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add Doctor</a>
                <hr>
                @include('partials.flash-message')
                <table class="table">
                    <thead>
                    <tr>
                        <th>National ID</th>
                        <th>Avatar Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        {{--                        <th>Password</th>--}}
                        <th>Created At</th>
                        <th>Is Banned</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <script src={{ asset("https://cdn.jsdelivr.net/npm/sweetalert2@10")}}></script>
<script>
    $('table').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('doctors.index') }}",
        columns: [
            {data: 'national_id'},
            {
                data: 'image',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return '<img src="' + data + '" alt="' + full.name + '" width="50">';
                }
            },
            {data: 'name'},
            {data: 'email'},
            {
                data: 'created_at', render: function (data, type, full, meta) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {data: 'is_banned'}, {
                data: 'id', orderable: false, searchable: false,
                render: function (data, type, full, meta) {
                    var banText = full.is_banned ? 'Unban' : 'Ban';
                    var banClass = full.is_banned ? 'btn-success' : 'btn-secondary';
                    var formAction = full.is_banned ? '{{ route('doctors.unban', ':id') }}' : '{{ route('doctors.ban', ':id') }}';
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var methodInput = '<input type="hidden" name="_method" value="PUT">';
                    var idInput = '<input type="hidden" name="id" value="' + data + '">';

                    var html = `
        <div class="d-flex  ">
            <a class="btn btn-info btn-sm mr-2" href="{{ route('doctors.edit', ':id') }}">
                <i class="fas fa-pencil-alt"></i> Edit
            </a>
            <button type="button" class="btn btn-danger btn-sm mr-2" onclick="sweetDelete(event)"
                    data-id="${data}">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
            <form method="POST" action="${formAction}">
                <input type="hidden" name="_token" value="${csrfToken}">
                ${methodInput}
                ${idInput}
                <button type="submit" class="btn ${banClass} btn-sm">
                    <i class="fas ${full.is_banned ? 'fa-lock-open' : 'fa-lock'}"></i> ${banText}
                </button>
            </form>
        </div>
    `;

                    return html.replaceAll(':id', data);
                }
            },

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
                    url: '/doctors/' + id,
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
