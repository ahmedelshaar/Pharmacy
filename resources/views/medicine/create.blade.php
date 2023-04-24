@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add a New medicine</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('medicine.store') }}" id="addNewMedicine" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" id="name" name="name" class="form-control" required autofocus>
                      </div>
                      <div class="form-group">
                          <label for="price">Price</label>
                          <input type="text" id="price" name="price" class="form-control" required>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="cost">Cost</label>
                          <input type="text" id="cost" name="cost" class="form-control" required>
                      </div>
                  </div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
@endsection
