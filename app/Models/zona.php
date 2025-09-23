<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'zonas';

    public function tiendas()
    {
        return $this->hasMany(Tienda::class, 'zona_id');
    }
}
