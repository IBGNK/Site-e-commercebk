<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'adresse', 'telephone', 'sexe','email'];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    public function pannier()
    {
        return $this->hasOne(Panier::class);
    }
}
