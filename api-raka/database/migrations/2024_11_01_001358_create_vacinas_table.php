<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacinasTable extends Migration
{
    public function up()
    {
        Schema::create('vacinas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_vacina', 255);
            $table->date('data_aplicacao');
            $table->string('numero_lote', 100);
            $table->integer('quantidade_cabecas')->nullable();
            $table->string('numero_identificacao', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacinas');
    }
}
