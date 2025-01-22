<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    use HasFactory;

    protected $table = 'canjes';
    protected $fillable = ['cliente_id', 'promocion_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function promocion()
    {
        return $this->belongsTo(Promocion::class);
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function empleado()
    {
        return $this->belongsTo(empleado::class);
    }
}
