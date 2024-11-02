<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumoRacaoTable extends Migration
{
    public function up()
    {
        Schema::create('consumo_racao', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_racao', 100);
            $table->decimal('quantidade_kg', 10, 2);
            $table->decimal('valor_estimado', 10, 2);
            $table->date('data_inicial');
            $table->date('data_final');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consumo_racao');
    }
}
