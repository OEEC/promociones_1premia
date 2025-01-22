<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleados';

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'tienda_id');
    }
}
