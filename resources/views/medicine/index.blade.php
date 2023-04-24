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
                <tbody>
                    @foreach($medicine as $row)
                        <tr>
                            <td>{{ $row->id}}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->price }}</td>
                            <td>{{ $row->cost }}</td>
                            <td>
                                <form action="{{ route('medicine.destroy', $row->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('medicine.edit', $row->id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

{{-- @section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        showMedicine();

        $('#addNewMedicine').on('submit' , function(e){
            e.preventDefault();
            let form = $(this).serialize();
            let url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: form,
                dataType: 'json',
                success: function(response) {
                    $('#addNewMedicine')[0].reset();
                    showMedicine();
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            });

        });
    });

    function showMedicine(){
        $.get("{{URL::to('medicine.index')}}" , function(data){
            $("#medicine-table").empty().html(data);
        })
    }
</script>
@endsection --}}
