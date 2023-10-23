@extends('layouts.app')
@section('content')
    @include('partials.flash-message')
    @if($order->status == 'Waiting')
        <div class="alert alert-warning">
            <strong>Warning!</strong> Your order is pending. Please pay to continue.
        </div>
        <form action="{{ route('stripe.post') }}" method="post">
            @csrf
            <input type="hidden" name="order_id" value="{{$order->id}}">
            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-amount="{{$order->total_price * 100}}"
                    data-name="Drugstore"
                    data-description="Drugstore Payment"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-currency="usd"
                    data-email="{{$order->user->email}}">
            </script>
        </form>
    @elseif($order->status == 'Cancelled')
        <div class="alert alert-danger">
            <strong>Warning!</strong> Your order is cancelled.
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

@endsection
