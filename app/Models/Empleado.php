<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleados';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'persona_id',
        'tienda_id',
        'estatus',
    ];

    public function persona() : BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function tienda() : BelongsTo
    {
        return $this->belongsTo(Tienda::class, 'tienda_id');
    }
}
