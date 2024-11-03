<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDeleteExpiredPasswordResetsEvent extends Migration
{
    public function up()
    {
        DB::unprepared('


        CREATE EVENT IF NOT EXISTS delete_all_password_resets
        ON SCHEDULE EVERY 30 MINUTE
        DO
        BEGIN
            DELETE FROM password_resets;
        END



        ');
    }

    public function down()
    {
        DB::unprepared('DROP EVENT IF EXISTS delete_all_password_resets');
    }
}
