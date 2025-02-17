<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'personas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_completo',
        'fecha_nacimiento',
        'cp',
    ];

    public function empleado()
    {
        return $this->hasOne(Empleado::class);
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'persona_id');
    }
}
