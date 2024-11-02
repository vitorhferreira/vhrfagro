<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastovetsTable extends Migration
{
    public function up()
    {
        Schema::create('gastovets', function (Blueprint $table) {
            $table->id();
            $table->text('motivo_gasto');
            $table->integer('qtd_cabecas');
            $table->date('data_pagamento')->nullable();
            $table->decimal('valor', 10, 2);
            $table->string('lote', 50);
            $table->boolean('pago')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gastovets');
    }
}
