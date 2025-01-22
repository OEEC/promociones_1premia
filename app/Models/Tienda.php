<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;
    protected $table = 'tiendas';

    public function canjes()
    {
        return $this->hasMany(Canje::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'tienda_id');
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }
}
