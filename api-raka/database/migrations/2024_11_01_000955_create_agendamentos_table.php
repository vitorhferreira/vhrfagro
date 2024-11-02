<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 11);
            $table->string('medico', 30);
            $table->date('data');
            $table->string('telefone', 11);
            $table->time('hora');
            $table->string('local', 255);
            $table->string('diagnostico', 800);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
