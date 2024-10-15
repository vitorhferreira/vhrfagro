<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    use HasFactory;

    // Definindo os campos que podem ser preenchidos em massa
    protected $fillable = [
        'lote_id',              // ID do lote
        'peso_medio_venda',      // Peso médio da venda
        'comprador',             // Nome do comprador
        'cpf_cnpj_comprador',    // CPF ou CNPJ do comprador
        'valor_unitario',        // Valor unitário da venda
        'quantidade_vendida',    // Quantidade vendida
        'prazo_pagamento',       // Prazo de pagamento
        'data_compra',           // Data da compra
        'documento',
    ];

    // Definindo a relação entre a venda e o lote
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
