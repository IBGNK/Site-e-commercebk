<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::all();

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    public function show(Client $client)
    {
        return Inertia::render('Clients/Show', [
            'client' => $client,
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'adresse' => 'nullable',
            'telephone' => 'nullable',
            'sexe' => 'nullable|in:M,F',
        ]);

        Client::create($request->all());

        return Redirect::route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    public function edit(Client $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => $client,
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'adresse' => 'nullable',
            'telephone' => 'nullable',
            'sexe' => 'nullable|in:M,F',
        ]);

        $client->update($request->all());

        return Redirect::route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return Redirect::route('clients.index')->with('success', 'Client supprimé avec succès.');
    }

}
