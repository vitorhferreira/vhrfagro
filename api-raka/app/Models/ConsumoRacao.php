<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoRacao extends Model
{
    use HasFactory;

    protected $table = 'consumo_racao';

    // Definindo os campos que podem ser preenchidos em massa
    protected $fillable = [
        'tipo_racao',      // Tipo de ração consumida
        'quantidade_kg',   // Quantidade de ração em kg
        'valor_estimado',  // Valor estimado da ração
        'data_inicial',    // Data inicial do consumo
        'data_final',      // Data final do consumo
    ];
}
