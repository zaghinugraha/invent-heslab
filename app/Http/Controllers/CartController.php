<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    public function checkSession()
    {
        session(['test' => 'Session is working']);
        dd(session('test'));
    }


    public function testCart()
    {
        Cart::add('293ad', 'Sample Product', 1, 9.99);
        dd(Cart::content());
    }

    public function index()
    {
        $cartItems = Cart::instance('shoppingcart')->content();
        $total = Cart::instance('shoppingcart')->total();
        return view('cart', ['cartItems' => $cartItems, 'total' => $total]);
    }

    public function add(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($product->quantity <= 0) {
            return redirect()->back()->with('error', 'Product is out of stock.');
        }

        $price = $product->price;
        Cart::instance('cart')->add($product->id, $product->name, 1, $price);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }




//    public function add(Request $request)
//    {
//        $product = Product::find($request->id);
//        $price = $product->price;
//        Cart::instance('cart')->add($product->id, $product->name, $product->quantity, $price)->associate('App\Models\Product');
//        return redirect()->back()->with('success', 'Product added to cart successfully!');
//    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
