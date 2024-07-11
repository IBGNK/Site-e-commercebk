<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanierController extends Controller
{
   /**
     * Display the contents of the cart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        return response()->json($cart);
    }

    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = Product::find($productId);
            $cart[$productId] = [
                'product_id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        return response()->json($cart);
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return response()->json($cart);
        }

        return response()->json(['message' => 'Product not found in cart'], 404);
    }

    /**
     * Remove a product from the cart.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return response()->json($cart);
        }

        return response()->json(['message' => 'Product not found in cart'], 404);
    }

    /**
     * Clear the cart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear()
    {
        Session::forget('cart');
        return response()->json(['message' => 'Cart cleared']);
    }
}
