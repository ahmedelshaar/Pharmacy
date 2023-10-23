@extends('layouts.admin')

@section('content')
    <section class="content mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">New Pharmacy</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pharmacies.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                                @if ($errors->has('name'))
                                    <div>
                                        <div class="text-danger">
                                            <ul>
                                                @foreach ($errors->get('name') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Logo</label>
                                <input type="file" id="avatar" name="avatar" min="1" class="form-control">
                                @if ($errors->has('avatar'))
                                    <div>
                                        <div class="text-danger">
                                            <ul>
                                                @foreach ($errors->get('avatar') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Priority</label>
                                <input type="number" id="priority" name="priority" min="1" class="form-control">
                                @if ($errors->has('priority'))
                                    <div>
                                        <div class="text-danger">
                                            <ul>
                                                @foreach ($errors->get('priority') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="area_id">Aria_id</label>
                                <select id="area_id" name="area_id" class="form-control">
                                    <option selected="" disabled="">Select Pharmacy's Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('area_id'))
                                    <div class="text-danger">
                                        <ul>
                                            @foreach ($errors->get('area_id') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <button role="button" value="Add" class="btn btn-success">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
