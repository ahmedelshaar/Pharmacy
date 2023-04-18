@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Doctors</h3>
                    <div class="card-tools">
                        <a href="{{ route('doctor.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a New Doctor</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="doctors-table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th><a href="#" class="sort" data-sort="name">Name</a></th>
                            <th><a href="#" class="sort" data-sort="email">Email</a></th>
                            <th><a href="#" class="sort" data-sort="national_id">National ID</a></th>
                            <th><a href="#" class="sort" data-sort="pharmacy_id">Pharmacy ID</a></th>
                            <th>Image</th>
                            <th><a href="#" class="sort" data-sort="created_at">Created At</a></th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($doctors as $doctor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="name">{{ $doctor->name }}</td>
                                <td class="email">{{ $doctor->email }}</td>
                                <td class="national_id">{{ $doctor->national_id }}</td>
                                <td class="pharmacy_id">{{ $doctor->pharmacy_id }}</td>
                                <td><img src="{{ $doctor->image }}" alt="{{ $doctor->name }}" class="img-thumbnail" style="max-height: 100px;"></td>
                                <td class="created_at">{{ $doctor->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('doctor.edit', $doctor->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $doctor->id }}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal-{{ $doctor->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $doctor->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel-{{ $doctor->id }}">Confirm Deletion</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete {{ $doctor->name }}?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('doctor.destroy', $doctor->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script>
        $(document).ready(function() {
            // DataTables plugin initialization
            $('#doctors-table').DataTable({
                // Sorting by 'name' column in ascending order by default
                order: [[1, 'asc']],
                // Enabling search functionality
                searching: true,
                // Customizing search input field
                language: {
                    searchPlaceholder: "Search by name, email, national ID, or pharmacy ID",
                    search: "",
                },
            });

            // Enable sorting when clicking on column headers
            $('.sort').click(function() {
                var column = $(this).data('sort');
                var order = $('#doctors-table').DataTable().order()[0][1];
                if (order === 'desc') {
                    $('#doctors-table').DataTable().order([[column, 'asc']]).draw();
                } else {
                    $('#doctors-table').DataTable().order([[column, 'desc']]).draw();
                }
            });

            // Enable search functionality
            $('#search-input').on('keyup', function() {
                $('#doctors-table').DataTable().search($(this).val()).draw();
            });
        });
    </script>
@endsection
