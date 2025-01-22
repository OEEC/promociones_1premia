<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    public function canjes()
    {
        return $this->hasMany(Canje::class);
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
