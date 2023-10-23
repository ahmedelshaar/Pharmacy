{{--@extends('layouts.app')--}}
{{--@section('content')--}}

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<div class="container text-center">
    <h1>Order Status</h1>
    @include('partials.flash-message')
    @if($order)
        @if($order->status == 'Waiting')
            <div class="alert alert-warning">
                <strong>Warning!</strong> Your order is pending. <a href="{{route('stripe')}}?id={{$order->id}}">Please
                    pay to continue.</a>
            </div>
        @elseif($order->status == 'Cancelled')
            <div class="alert alert-danger">
                <strong>Warning!</strong> Your order is cancelled.
            </div>
        @elseif($order->status == 'Processing')
            <div class="alert alert-info">
                <strong>Warning!</strong> Your order is processing.
            </div>

        @elseif($order->status == 'Confirmed')
            <div class="alert alert-success">
                <strong>Success!</strong> Your order is paid.
            </div>
        @elseif($order->status == 'Delivered')
            <div class="alert alert-success">
                <strong>Success!</strong> Your order is delivered.
            </div>
        @endif
        <table class="table table-dark table-bordered align-middle">
            <tr>
                <td>Order ID</td>
                <td>{{$order->id}}</td>
            </tr>
            <tr>
                <td>Order Name</td>
                <td>{{$order->user->name}}</td>
            </tr>
            <tr>
                <td>Order Email</td>
                <td>{{$order->user->email}}</td>
            </tr>
            <tr>
                <td>Order Address</td>
                <td>{{$order->delivering_address->street_name}}, {{$order->delivering_address->area->name}}</td>
            </tr>
            <tr>
                <td>Order Status</td>
                <td>{{$order->status}}</td>
            </tr>
            <tr>
                <td>Order Total</td>
                <td>{{$order->total_price}} USD</td>
            </tr>
            <tr>
                <td>Order Created At</td>
                <td>{{$order->created_at}}</td>
            </tr>
            <tr>
                <td>Order Details</td>
                <td class="p-0 m-0">
                    <table class="table table-bordered text-center text-light m-0 ">
                        <tr>
                            <th>Medicine Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                        @foreach($order->medicines as $medicine)
                            {{--                        @dd($order->medicines)--}}

                            <tr>
                                <td>{{$medicine->name}}</td>
                                <td>{{$medicine->pivot->quantity}}</td>
                                <td>{{$medicine->pivot->price}}</td>
                                <td>{{$medicine->pivot->quantity*$medicine->pivot->price}}</td>
                            </tr>

                        @endforeach

                    </table>
                </td>
            </tr>
        </table>
    @else
        <div class="alert alert-danger">
            <strong>Warning!</strong> No order found.
        </div>
    @endif

</div>

{{--@endsection--}}

