<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function stripe(Request $request)
    {
        $url = $request->root();
        $order = Order::where('id', $request->query('id'))->firstOrFail();

        if ($order->status != 'Waiting') {
            return redirect()->route('order.status', ['id' => $order->id]);
        }

        if ($order->stripe_session_id) {
            $checkout_session = Session::retrieve($order->stripe_session_id);
            $checkout_session->expire();
        }

        $products = [];
        $total_price = 0;
        foreach ($order->medicines as $medicine) {
            $products[] = ['price_data' =>
                [
                    'currency' => 'usd',
                    'unit_amount' => $medicine->pivot->price * 100,
                    'product_data' => [
                        'name' => $medicine->name,
                        'description' => $medicine->type->name,
                        //'images' => [$order->pharmacy?->avatar?->getUrl()],
                    ],
                ],
                'quantity' => $medicine->pivot->quantity,
            ];
            $total_price += $medicine->pivot->price * $medicine->pivot->quantity;
        }
        $order->total_price = $total_price;
        $order->save();


        $checkout_session = Session::create([
            'line_items' => $products,
            'mode' => 'payment',
            "customer_email" => $order->user->email,
            "payment_method_types" => ["card","alipay"],
            'success_url' => route('stripe.success', ['id' => $order->id]),
            'cancel_url' => route('stripe.cancel', ['id' => $order->id]),
            'client_reference_id' => $order->id,
        ]);
//        dd($checkout_session);
        $stripe_session_id = $checkout_session->id;
        $order->stripe_session_id = $stripe_session_id;
        $order->save();
        return redirect($checkout_session->url, 303);
    }

    public function stripeSuccess(Request $request)
    {

        $order = Order::find($request->id);
        $session_id = $order->stripe_session_id;
//        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($session_id);
        if ($session->payment_status != 'paid') {
            return redirect()->route('order.status', ['id' => $order->id])->with('error', 'Payment failed!');
        }
        $order->status = 'Confirmed';
        $order->save();
        return redirect()->route('order.status', ['id' => $order->id])->with('success', 'Payment successful!');
    }

    public function stripeCancel(Request $request)
    {
        $order = Order::find($request->id);
        if ($order->status != 'Waiting') {
            return redirect()->route('order.status', ['id' => $order->id]);
        }
        $order->status = 'Canceled';
        $order->save();
        return redirect()->route('order.status', ['id' => $order->id])->with('error', 'Payment failed!');
    }

    public function status($id)
    {
        $order = Order::find($id);
        return view('status', compact('order'));
    }

}
