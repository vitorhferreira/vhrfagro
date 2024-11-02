<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade');
            $table->decimal('peso', 10, 2);
            $table->decimal('valor_individual', 10, 2);
            $table->integer('idade_media');
            $table->date('data_compra');
            $table->string('numero_lote', 50);
            $table->string('documento')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->boolean('pago')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotes');
    }
}
