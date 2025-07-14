<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendLogToDiscord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:send-discord';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um log de teste para o Discord';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('log funcionando');
        $this->info('Log enviado para o Discord com sucesso.');

        return Command::SUCCESS;
    }
}
