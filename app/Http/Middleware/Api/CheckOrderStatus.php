<?php

namespace App\Http\Middleware\Api;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $orderId = $request->route('order');
        $order = Order::find($orderId);

        if ($order->status !== 'New') {
            return response()->json(['error' => 'You are not allowed to modify this order.'], 403);
        }

        return $next($request);
    }
}
