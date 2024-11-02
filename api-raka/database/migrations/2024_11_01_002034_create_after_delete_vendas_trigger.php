<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAfterDeleteVendasTrigger extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER after_delete_vendas AFTER DELETE ON vendas FOR EACH ROW
            BEGIN
                DELETE FROM relatorio WHERE id_venda = OLD.id;
            END
        ");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_delete_vendas");
    }
}
