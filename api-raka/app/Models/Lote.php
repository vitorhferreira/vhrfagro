<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;
    protected $fillable = ['quantidade','peso', 'valor_individual', 'idade_media', 'data_compra', 'numero_lote', 'documento','data_pagemento', 'pago'];
}
