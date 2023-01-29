<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    //
    public function addItemToCart(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|numeric'
        ]);

        $product = Product::find($request->product_id);

        $request->quantity ? $quantity = $request->quantity : $quantity = 1;
        $subtotal = (float) $product->price *  $quantity;

        // add item or update quantity if found
        $cartItem = CartItem::where(['product_id' => $request->product_id, 'user_id' => $request->user()->id])->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->subtotal_price = $subtotal;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'subtotal_price' => $subtotal,
            ]);
        }
        return response()->json($cartItem)->setStatusCode(201);
    }

    //
    public function show(Request $request)
    {
        $cartItems = CartItem::where([
            'cart_items.user_id' => $request->user()->id
            
        ])
            ->select([
                'cart_items.quantity', 'cart_items.product_id',
                "products.title",
                "products.price",
            ])
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->get();

        // total
        $total = CartItem::where(['user_id'=> $request->user()->id ])->sum('subtotal_price');
        return response()->json([
            
            'total' => $total,  'cartItems' => $cartItems
        ]);
    }
}
