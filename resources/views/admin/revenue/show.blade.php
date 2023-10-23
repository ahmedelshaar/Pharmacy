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
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            {{$pharmacy->id}}
                        </td>
                        <td>
                            <img src="{{asset($pharmacy->avatar)}}" alt="{{$pharmacy->name}}"
                                 class="img-circle img-size-64 mr-2">
                        </td>
                        <td>
                            {{$pharmacy->name}}
                        </td>
                        <td>
                            {{$pharmacy->orders->count()}}
                        </td>
                        <td>
                            {{$pharmacy->orders->sum('total_price')}}
                        </td>
                    </tr>
                    </tbody>
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

@endsection
