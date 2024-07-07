<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pannier extends Model
{
    use HasFactory;
    protected $fillable = ['client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_panier')->withPivot('quantite');
    }
}
