<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEventAtualizarIdadeMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE EVENT IF NOT EXISTS atualizar_idade_media
            ON SCHEDULE EVERY 1 MONTH
            STARTS '2024-12-01 00:00:00'
            DO
            BEGIN
                UPDATE lotes
                SET idade_media = idade_media + 1;
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP EVENT IF EXISTS atualizar_idade_media");
    }
}
