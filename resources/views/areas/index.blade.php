@extends('layouts.admin')

@section('content')
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Areas</h3>
                    <div class="card-tools">
                        <a href="{{ route('areas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add a New Area</a>
                    </div>
                </div>
                <div class="card-body">
    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Country_id</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($area as $area)
                <tr>
                    <td>{{ $area->id}}</td>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->country_id }}</td>
                    <td>
                    {{ \Carbon\Carbon::parse($area->created_at)->isoFormat('MMMM Do YYYY') }}
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('areas.edit', ['area' => $area['id']]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{route('areas.destroy', ['area' => $area->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                            </form>

                        </div>
                    </td>
                     
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
     </div>
    </div>
    </div>
@endsection