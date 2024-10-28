<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    use HasFactory;

    protected $table = 'individual';

    protected $fillable = [
        'numero_identificacao',
        'id_lote',
        'numero_lote',
        'peso',
        'data',
        'anotacoes',
    ];

    // Relacionamento com o lote
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote');
    }
}
