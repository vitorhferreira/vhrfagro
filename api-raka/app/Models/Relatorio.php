<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    use HasFactory;

    protected $table = 'relatorio'; // Definindo a tabela associada a essa model

    // Definindo os campos que podem ser preenchidos em massa
    protected $fillable = [
        'lote_id',           // ID do lote
        'valor_compra',       // Valor da compra do lote
        'peso_comprado',
        'quantidade_comprada',
        'valor_venda',
        'peso_vendido',
        'quantidade_vendida',         // Quantidade de cabeças no lote
        'total_gastos',      // Total de gastos no lote
        'total_vacinas',
        'lucro',              // Lucro calculado
        'numero_lote',
    ];

}
