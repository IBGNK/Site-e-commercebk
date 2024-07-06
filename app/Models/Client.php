<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenome',
        'address',
        'phone',
        'sexe', // M pour Masculin, F pour Féminin
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
