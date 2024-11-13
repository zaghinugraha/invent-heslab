<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::instance('cart')->content();
        return view('cart', ['cartItems' => $cartItems]);
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);

        // Check if product exists in cart
        $duplicates = Cart::instance('cart')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });

        if ($duplicates->isNotEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item already in cart'
            ]);
        }

        Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'options' => [
                'image' => $product->image
            ]
        ])->associate(Product::class);

        return response()->json([
            'status' => 'success',
            'message' => 'Item added to cart successfully',
            'cartCount' => Cart::instance('cart')->count()
        ]);


    }

    public function checkSession()
    {
        if (session()->has('test')) {
            return response()->json(['message' => session('test')]);
        }
        return response()->json(['message' => 'No session found']);
    }

    public function testCart()
    {
        Cart::instance('cart')->add('293ad', 'Sample Product', 1, 9.99);
        return response()->json(['cart' => Cart::instance('cart')->content()]);
    }
}
