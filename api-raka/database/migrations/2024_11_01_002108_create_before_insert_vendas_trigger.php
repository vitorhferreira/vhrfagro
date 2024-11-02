<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBeforeInsertVendasTrigger extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER before_insert_vendas BEFORE INSERT ON vendas FOR EACH ROW
            BEGIN
                SET NEW.numero_lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);
            END
        ");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_vendas");
    }
}

