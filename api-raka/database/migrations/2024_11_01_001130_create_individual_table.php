<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualTable extends Migration
{
    public function up()
    {
        Schema::create('individual', function (Blueprint $table) {
            $table->id();
            $table->string('numero_identificacao', 50);
            $table->foreignId('id_lote')->constrained('lotes');
            $table->string('numero_lote', 50);
            $table->decimal('peso', 10, 2);
            $table->date('data');
            $table->text('anotacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('individual');
    }
}
