<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'promociones';
    protected $fillable = [
        'nombre',
        'imagen',
        'fecha_vigencia',
        'estatus',
        'dias_aplicables',
        'hora_inicio',
        'hora_fin',
    ];
    
    public function canjes()
    {
        return $this->hasMany(Canje::class);
    }
}
