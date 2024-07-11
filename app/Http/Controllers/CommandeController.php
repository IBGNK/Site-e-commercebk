<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandeController extends Controller
{
   /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::with('products')->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = new Order();
        $order->client_id = $request->client_id;
        $order->total_amount = 0;
        $order->save();

        $totalAmount = 0;
        foreach ($request->products as $product) {
            $prod = Product::find($product['id']);
            $order->products()->attach($prod, ['quantity' => $product['quantity']]);
            $totalAmount += $prod->price * $product['quantity'];
        }

        $order->total_amount = $totalAmount;
        $order->save();

        return response()->json($order, 201);
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Order::with('products')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->client_id = $request->client_id;
        $order->total_amount = 0;
        $order->save();

        $order->products()->detach();

        $totalAmount = 0;
        foreach ($request->products as $product) {
            $prod = Product::find($product['id']);
            $order->products()->attach($prod, ['quantity' => $product['quantity']]);
            $totalAmount += $prod->price * $product['quantity'];
        }

        $order->total_amount = $totalAmount;
        $order->save();

        return response()->json($order);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted']);
    }
}
