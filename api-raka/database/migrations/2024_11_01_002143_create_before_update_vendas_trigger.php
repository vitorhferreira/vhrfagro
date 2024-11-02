<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBeforeUpdateVendasTrigger extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER before_update_vendas BEFORE UPDATE ON vendas FOR EACH ROW
            BEGIN
                SET NEW.numero_lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);
            END
        ");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_update_vendas");
    }
}

