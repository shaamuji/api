<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    //

    public function create(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string|min:3|max:50',
            'description' => 'nullable|string|max:100',
            'price' => 'required|numeric',
        ]);

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json($product)->setStatusCode(201);
    }

    public function update(Request $request,  $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json($product)->setStatusCode(201);

    }

    public function show(Request $request,  $id)
    {
        $product = Product::find($id);
        return $product ?  response()->json($product) : response()->json(['error'=>'product not found'])->setStatusCode(404) ;

    }

    public function index(Request $request)
    {
        return response()->json(Product::all());

    }

    public function destroy(Request $request,  $id)
    {
        Product::destroy($id);
        return response()->json()->setStatusCode(204);

    }

}
