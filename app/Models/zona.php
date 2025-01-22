<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zona extends Model
{
    use HasFactory;
    protected $table = 'zonas';

    public function tiendas()
    {
        return $this->hasMany(Tienda::class, 'zona_id');
    }
}
