@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pharmacy</h3>
                    <div class="card-tools">
                        <a href="{{ route('pharmacy.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a
                            New
                            Pharmacy</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="doctors-table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><a href="#" class="sort" data-sort="name">Name</a></th>
                                <th><a href="#" class="sort" data-sort="priority">Priority</a></th>
                                <th><a href="#" class="sort" data-sort="area">Area</a></th>
                                <th><a href="#" class="sort" data-sort="avatar">Pharmacy Image</a></th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
