<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteOldPasswordResets extends Command
{
    protected $signature = 'password_resets:clean';
    protected $description = 'Exclui registros de redefinição de senha com mais de 30 minutos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $expirationTime = Carbon::now()->subMinutes(30);
        DB::table('password_resets')
            ->where('created_at', '<', $expirationTime)
            ->delete();

        $this->info('Registros antigos de password_resets foram limpos.');
    }
}
