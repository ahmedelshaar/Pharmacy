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
                        <tbody>
                            @foreach ($pharmacies as $pharmacy)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="name">{{ $pharmacy->name }}</td>
                                    <td class="priority">{{ $pharmacy->priority }}</td>
                                    <td class="area_id">{{ $pharmacy->area->name }}</td>
                                    @if ($pharmacy->avatar)
                                        <td class="avatar"><img src="{{ $pharmacy->avatar }}" alt="{{ $pharmacy->name }}"
                                                class="img-thumbnail" style="max-height: 100px;"></td>
                                    @else
                                        <td class="avatar"><img src="{{ asset('images/placeholder.png') }}"
                                                alt="{{ $pharmacy->name }}" class="img-thumbnail"
                                                style="max-height: 100px;">
                                        </td>

                                        <div class="btn-group">
                                            <a href="{{ route('pharmacy.edit', $pharmacy->id) }}"
                                                class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal-{{ $pharmacy->id }}"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                        </td>
                                </tr>

                                {{-- for delete Modal --}}
                                <div class="modal fade" id="deleteModal-{{ $pharmacy->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel-{{ $pharmacy->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel-{{ $pharmacy->id }}">Confirm
                                                    Deletion</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete {{ $pharmacy->name }}?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('pharmacy.destroy', $pharmacy->id) }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
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
