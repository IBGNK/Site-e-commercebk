<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProduitController extends Controller
{

    namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();

        return Inertia::render('Produits/Index', [
            'produits' => $produits,
        ]);
    }

    public function show(Produit $produit)
    {
        return Inertia::render('Produits/Show', [
            'produit' => $produit,
        ]);
    }

    public function create()
    {
        // Vérifie si l'utilisateur est autorisé à ajouter un produit
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        return Inertia::render('Produits/Create');
    }

    public function store(Request $request)
    {
        // Vérifie si l'utilisateur est autorisé à ajouter un produit
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $request->validate([
            'nom' => 'required',
            'description' => 'nullable',
            'prix' => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            // Ajoutez d'autres validations selon vos besoins
        ]);

        Produit::create($request->all());

        return Redirect::route('produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit(Produit $produit)
    {
        // Vérifie si l'utilisateur est autorisé à modifier un produit
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        return Inertia::render('Produits/Edit', [
            'produit' => $produit,
        ]);
    }

    public function update(Request $request, Produit $produit)
    {
        // Vérifie si l'utilisateur est autorisé à modifier un produit
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $request->validate([
            'nom' => 'required',
            'description' => 'nullable',
            'prix' => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            // Ajoutez d'autres validations selon vos besoins
        ]);

        $produit->update($request->all());

        return Redirect::route('produits.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        // Vérifie si l'utilisateur est autorisé à supprimer un produit
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $produit->delete();

        return Redirect::route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }

}
