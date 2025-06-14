<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residuo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo',
        'cantidad_kg',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

