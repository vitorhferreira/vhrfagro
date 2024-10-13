<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gastovet extends Model
{
    use HasFactory;
    protected $fillable = ['motivo_gasto', 'qtd_cabecas', 'data_pagamento', 'valor' , 'lote', 'pago'];
}
