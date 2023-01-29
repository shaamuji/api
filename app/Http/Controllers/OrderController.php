<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $orderItems = [];
        $cartItems = CartItem::where(['user_id' => $request->user()->id])->get();
        if ($cartItems && count($cartItems) > 0) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_state_id' => 1, 'store_id' => 1,
                'total_price' => 0, 'total_vat' => 0,
                'price_without_vat' => 0,

            ]);
            foreach ($cartItems as $item) {
                array_push($orderItems, [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'subtotal_price' => $item->quantity * $item->product->price,


                ]);
            }

            $order->orderItems()->createMany($orderItems);

            $order->total_price = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where(['orders.user_id' => $request->user()->id])
                ->sum("order_items.subtotal_price");


            $order->save();
            // make cart empty again after submit order
            CartItem::where('user_id', $request->user()->id)->delete();

            return response()->json($order)->setStatusCode(201);
        } else {
            return response()->json(['error' => 'your cart is empty'])->setStatusCode(404);
        }
    }

    public function show(Request $request, $id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::where(['order_items.order_id' => $id])
            ->select([
                'order_items.quantity', 'order_items.product_id',
                 "products.title",
                "order_items.subtotal_price",
                "products.price",
            ])
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->get();

        return response()->json(['orderSummary' => $order, 'orderItems' => $orderItems]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'order_state_id' => 'required|exists:order_states,id',
        ]);

        $order = Order::find($id);
        $order->update([
            'order_state_id' => $request->order_state_id
        ]);
        return response()->json($order);
    }

    public function destroy(Request $request,  $id)
    {
        Order::destroy($id);
        return response()->json()->setStatusCode(204);

    }

    public function index(Request $request)
    {
        return response()->json(Order::all());

    }
}
