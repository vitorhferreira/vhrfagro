<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes');
            $table->decimal('peso_medio_venda', 10, 2);
            $table->string('comprador', 255);
            $table->string('cpf_cnpj_comprador', 18);
            $table->decimal('valor_unitario', 10, 2);
            $table->integer('quantidade_vendida');
            $table->string('prazo_pagamento', 50)->nullable();
            $table->date('data_compra');
            $table->string('documento')->nullable();
            $table->boolean('recebido')->default(0);
            $table->string('numero_lote', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
