<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatorioTable extends Migration
{
    public function up()
    {
        Schema::create('relatorio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes');
            $table->decimal('valor_compra', 10, 2);
            $table->decimal('peso_comprado', 10, 2);
            $table->integer('quantidade_comprada');
            $table->decimal('valor_venda', 10, 2);
            $table->decimal('peso_vendido', 10, 2);
            $table->integer('quantidade_vendida');
            $table->decimal('total_gastos', 10, 2);
            $table->integer('total_vacinas');
            $table->decimal('lucro', 10, 2);
            $table->string('numero_lote', 50)->nullable();
            $table->integer('id_venda');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('relatorio');
    }
}
