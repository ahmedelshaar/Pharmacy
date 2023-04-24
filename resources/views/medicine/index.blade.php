@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Medicine</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                <a href="{{ route('medicine.create') }}" class="btn btn-success" id="create-medicine"><i class="fas fa-plus"></i> Add a New Medicine</a>
            </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body">
            <table id="medicine-table" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Cost</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
