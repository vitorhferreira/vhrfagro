<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacina extends Model
{
    use HasFactory;
    protected $fillable = ['nome_vacina','data_aplicacao', 'numero_lote', 'quantidade_cabecas', 'numero_identificacao'];
}
