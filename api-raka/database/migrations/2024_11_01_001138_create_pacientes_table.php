<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 11)->unique();
            $table->string('nome', 255);
            $table->string('senha', 255);
            $table->date('nascimento');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
