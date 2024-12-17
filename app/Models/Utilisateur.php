<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    //
    protected $table = 'utilisateur';
    protected $fillable = ['id','email', 'mdp', 'nom', 'isverified', 'tentative'];
    protected $casts = [
        'isverified' => 'boolean',  
        'tentative' => 'integer'
    ];

}
