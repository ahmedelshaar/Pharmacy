@extends('layouts.admin')

@section('content')
    <section class="content mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Pharmacy</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pharmacies.update', ['pharmacy' => $pharmacy->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $pharmacy['name'] }}">
                                @if ($errors->has('name'))
                                    <div class="text-danger">
                                        <ul>
                                            @foreach ($errors->get('name') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Logo</label><br>
                                <img src="{{ asset($pharmacy->avatar) }}" alt="Avatar" width="80"><br><br>
                                <input type="file" class="form-control" name="avatar" value="{{ $pharmacy['avatar'] }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Priority</label>
                                <input type="number" class="form-control" name="priority" value="{{ $pharmacy['priority'] }}">
                                @if ($errors->has('priority'))
                                    <div class="text-danger">
                                        <ul>
                                            @foreach ($errors->get('priority') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Area_id</label>
                                <select id="area_id" name="area_id" class="form-control">
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}" {{ old('area_id', $pharmacy->area_id) == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                                    @endforeach
                                </select>
                                <br>
                            <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
