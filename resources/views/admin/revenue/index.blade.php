@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pharmacies Revenue</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" href="{{route('revenue.index')}}">Revenue</li>
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
            <div class="card-body p-3">
                <table id="table" class="table table-striped table-borderless  text-center">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Pharmacy Avatar
                        </th>
                        <th>
                            Pharmacy Name
                        </th>
                        <th>
                            Total Orders
                        </th>
                        <th>
                            Total Revenue ($)
                        </th>
                        <th>
                            Action
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
    <script>
        $('table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('revenue.index') }}",
            columns: [
                {data: null},
                {
                    data: 'avatar',
                    render: (data, display, full) => `<img class="img-circle img-size-64 mr-2" src="${data}" alt="${full.name}">`
                },
                {data: 'name'},
                {data: 'total_orders'},
                {data: 'total_sales', render: $.fn.dataTable.render.number(',', '.', 2, '$'), searchable: true},
                {data: 'action'},

            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(index + 1);
            }
        })
        ;
    </script>

@endsection
