<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * Display a listing of the clients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|string|max:20',
            'sexe' => 'required|string|in:M,F',
        ]);

        $client = Client::create($request->all());

        return response()->json($client, 201);
    }

    /**
     * Display the specified client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json($client);
    }

    /**
     * Update the specified client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'telephone' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|string|max:20',
            'sexe' => 'sometimes|required|string|in:M,F',
        ]);

        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->update($request->all());

        return response()->json($client);
    }

    /**
     * Remove the specified client from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted']);
    }

    /**
     * Display the order history for the specified client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderHistory($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $orders = Order::where('client_id', $id)->get();

        return response()->json($orders);
    }

}
