@extends('layouts.admin')
@section('title', 'Add New Pharmacy')
@section('content')

<div class="conatiner mx-5">

<h1>Add New Pharmacy</h1>

    @if ($errors->any())
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{route('pharmacy.store')}}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label class="form-label">Pharmacy Name</label>
            <input  type="text" name="name" class="form-control" >
        </div>
        <div class="mb-3">
            <label class="form-label">Pharmacy Priority</label>
            <select class="form-control" name="priority">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

        </div>

        <div class="mb-3">
            <label  class="form-label">Area</label>
            <select class="form-control" name="area_id">
            @foreach($areas as $area)
                <option value="{{$area->id}}">{{$area->name}}</option>
            @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Pharmacy Image</label>
            <input class="form-control" type="file" id="formFile" name="avatar">
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>

</div>
@endsection
