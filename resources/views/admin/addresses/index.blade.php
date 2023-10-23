@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users Addresses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">addresses</li>
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
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                #
                            </th>
                            <th style="width: 20%">
                                Area Name
                            </th>
                            <th style="width: 20%">
                                Street Name
                            </th>
                            <th style="width: 5%">
                                Building No.
                            </th>
                            <th style="width: 5%">
                                Floor No.
                            </th>
                            <th style="width: 5%">
                                Flat No.
                            </th>
                            <th style="width: 5%">
                                Main Address
                            </th>
                            <th style="width: 15%">
                                User Name
                            </th>
                            <th style="width: 30%">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($addresses as $address)
                                <tr>
                                    <td>{{ $address->id }}</td>
                                    <td>{{ $address->area->name }}</td>
                                    <td>{{ $address->street_name }}</td>
                                    <td>{{ $address->building_number }}</td>
                                    <td>{{ $address->floor_number }}</td>
                                    <td>{{ $address->flat_number }}</td>
                                    <td>{{ $address->is_main ? 'Yes' : 'No' }}</td>
                                    <td>{{ $address->user->name }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('addresses.destroy', $address->id) }}" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>
                                                <i class="fas fa-trash">
                                                </i>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex">
                        {!! $addresses->links() !!}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
@endsection



@section('scripts')
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <script type="text/javascript">

        $('.show_confirm').click(function(event) {
            let form =  $(this).closest("form");
            let name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>

@endsection
