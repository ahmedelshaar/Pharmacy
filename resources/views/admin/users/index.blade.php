@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('partials.flash-message')
            <div class="card">
                <div class="card-body p-2 w-100">
                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                 Name
                            </th>
                            <th>
                                 Email
                            </th>
                            <th>
                               Gender
                            </th>
                            <th>
                                Phone
                            </th>
                            <th>
                                Birth date
                            </th>

                            <th>
                                National id
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>

                    </table>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
@endsection



@section('scripts')
    <script>
        $('table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            width:'100%',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {
                    data: 'email',
                    orderable: false,
                },
                {
                    data: 'gender',
                    orderable: false,
                    searchable: false,},
                {
                    data: 'phone',
                    orderable: false,
                    searchable: false,
                },
                {data: 'birth_date'},
                {
                    data: 'national_id',
                    orderable: false,
                },
            ]
        });
    </script>
@endsection
