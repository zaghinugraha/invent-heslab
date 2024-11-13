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
        try {
            $request->validate([
                'id' => 'required|exists:products,id',
                'quantity' => 'required|numeric|min:1'
            ]);

            $product = Product::findOrFail($request->id);

            // Check if requested quantity is available
            if ($request->quantity > $product->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity not available'
                ], 400);
            }

            // Check if product already in cart
            $duplicates = Cart::instance('cart')->search(function ($cartItem) use ($product) {
                return $cartItem->id === $product->id;
            });

            if ($duplicates->isNotEmpty()) {
                // Update quantity if already in cart
                $cartItem = $duplicates->first();
                $newQty = $cartItem->qty + $request->quantity;

                if ($newQty > $product->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more of this item'
                    ], 400);
                }

                Cart::instance('cart')->update($cartItem->rowId, $newQty);
            } else {
                // Add new item to cart
                Cart::instance('cart')->add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => $request->quantity,
                    'price' => $product->price,
                    'weight' => 0,
                    'options' => [
                        'product_image' => $product->product_image ?? 'default-image.jpg'
                    ]
                ])->associate(Product::class);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cartCount' => Cart::instance('cart')->count(),
                'cartTotal' => Cart::instance('cart')->subtotal(0),
                'cartContents' => Cart::instance('cart')->content()
            ]);

        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding item to cart. Please try again.'
            ], 500);
        }
    }

    public function remove($rowId)
    {
        try {
            Cart::instance('cart')->remove($rowId);
            return redirect()->back()->with('success', 'Item removed from cart.');
        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error removing item from cart.');
        }
    }

    public function update(Request $request, $rowId)
    {
        try {
            $request->validate([
                'quantity' => 'required|numeric|min:1'
            ]);

            Cart::instance('cart')->update($rowId, $request->quantity);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating cart.');
        }
    }

    public function clear()
    {
        try {
            Cart::instance('cart')->destroy();
            return redirect()->back()->with('success', 'Cart cleared successfully.');
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error clearing cart.');
        }
    }
}
