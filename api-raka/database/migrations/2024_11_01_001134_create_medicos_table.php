<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicosTable extends Migration
{
    public function up()
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('cpf', 11);
            $table->integer('idade');
            $table->string('profissao', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicos');
    }
}
