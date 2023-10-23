@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order #{{$order->id}} Medicines</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" href="{{route('orders.index')}}">Orders</li>
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
                <table id="table" class="table table-striped table-borderless text-center ">
                    <thead>
                    <tr>
                        <th style="width: 1%">#</th>
                        <th>Medicine Name</th>
                        <th>Medicine Type</th>
                        <th>Quantity</th>
                        <th>Unit Price ($)</th>
                        <th>Total Price ($)</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    {{-- <tbody>
                     --}}{{--                    @dd($order->order_medicine_quantity);--}}{{--

                     @foreach($order->order_medicine_quantity as $orderMedicine)
                         <tr>
                             <td>{{$loop->iteration}}</td>
                             <td>{{$orderMedicine->medicine->name}}</td>
                             <td>{{$orderMedicine->medicine->type->name}}</td>
                             <td>{{$orderMedicine->quantity}}</td>
                             <td>{{$orderMedicine->price}}</td>
                             <td>{{$orderMedicine->quantity*$orderMedicine->price}}</td>
                             @php
                                 $total += $orderMedicine->quantity*$orderMedicine->price
                             @endphp
                             <td>
                                 <button class="btn btn-danger btn-sm"
                                         onclick="sweetDelete(event)"
                                         data-id="{{$orderMedicine->medicine_id}}">
                                     <i class="fas fa-trash-alt"></i> Delete
                                 </button>
                             </td>
                         </tr>
                     @endforeach
                     </tbody>--}}
                    <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="4" class="h1 text-left">Total</td>
                        <td>{{$total}}</td>
                        <td>
                            <form
                                action="{{route('medicineQuantity.store',$order->id)}}"
                                method="post">
                                @csrf
                                <button class="btn btn-success btn-sm" type="submit">
                                    <i class="fas fa-plus"></i> Save
                                </button>
                            </form>
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                @include('partials.validation_errors')
                {{--                @dd($order)--}}
                <form id="add_medicine" action="{{ route('orders.update',$order->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="medicine">Medicine</label>
                        <select name="medicine_id" id="add_medicine_medicine" class="form-control">
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}">{{ $medicine->name }}
                                    {{ $medicine->price }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="add_medicine_quantity"
                               class="form-control" required>
                    </div>
                    <input onclick="add_medicine(event)" id="add_medicine_btn" type="submit" value="Add"
                           class="my-3 btn btn-success">
                </form>
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    {{--    DataTable Script--}}
    <script>
        $('table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders.edit',$order->id) }}",
            columns: [
                // first column for the row index
                {data: null, searchable: false},
                {data: 'name'},
                {data: 'type'},
                {data: 'pivot.quantity'},
                {data: 'pivot.price', render: $.fn.dataTable.render.number(',', '.', 2, '$')},
                {
                    data: (data) => data.pivot.quantity * data.pivot.price,
                    render: $.fn.dataTable.render.number(',', '.', 2, '$')
                },
                {
                    data: 'id', orderable: false, searchable: false,
                    render: (data, type, full, meta) => {
                        return `
                                     <button class="btn btn-danger btn-sm"
                                                     onclick="sweetDelete(event)"
                                                     data-id=":id">
                                                 <i class="fas fa-trash-alt"></i> Delete
                                             </button>`.replaceAll(':id', data);
                    },
                }
            ],
            // add row index to the first column after the table is drawn
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(index + 1); // add index
                console.log(data, row, index);
                // edit the total row
                let total = $("tfoot td:eq(-2)");
                total.text(parseFloat(total.text().replace(/[^0-9.]/g, '')) + data.pivot.quantity * data.pivot.price);
            },
            // after finish
            drawCallback: function (event,) {
                console.log('drawCallback');
                let data = this.api().data();
                let total = 0;
                data.each(function (value, index) {
                    total += value.pivot.quantity * value.pivot.price;
                });
                console.log(total);
                let totalRow = $("tfoot td:eq(-2)");
                totalRow.text("$" + parseFloat(total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

            }
        })
        ;
    </script>
    {{--add medicine script--}}
    <script>
        function add_medicine(e) {
            e.preventDefault();
            let btn = document.getElementById('add_medicine_btn');
            let medicine = document.getElementById('add_medicine_medicine');
            let quantity = document.getElementById('add_medicine_quantity');
            btn.disabled = true;
            $.ajax({
                type: 'POST',
                url: "{{route('orders.update',':id')}}".replaceAll(":id", {{$order->id}}),
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'PUT',
                    "medicine_id": medicine.value,
                    "quantity": quantity.value,
                },
                success: function (data) {
                    // console.log(data);

                    Swal.fire(
                        'Added!',
                        'The record has been Added.',
                        'success'
                    );

                },
                error: function (data) {
                    Swal.fire(
                        'Error!',
                        'An error occurred while Adding the record.',
                        'error'
                    );
                },
                complete: function () {
                    $('table').DataTable().ajax.reload();
                    btn.disabled = false;
                    quantity.value = '';
                }
            });
        }


    </script>
    {{--    Delete Script--}}
    <script>
        // Handle the SweetAlert confirmation dialog for delete actions
        function sweetDelete(e) {
            e.preventDefault();

            const id = $(e.target).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {


                    // Send the delete request
                    $.ajax({
                        type: 'POST',
                        url: "{{route('medicineQuantity.destroy',':id')}}".replaceAll(":id", {{$order->id}}),
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE',
                            "medicine_id": id
                        },
                        success: function (data) {
                            // console.log(data);
                            $('table').DataTable().ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                'The record has been deleted.',
                                'success'
                            );

                        },
                        error: function (data) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the record.',
                                'error'
                            );
                        }
                    });

                }
            });
        }

        // $('.swal-delete').click(sweetDelete);
    </script>
@endsection
