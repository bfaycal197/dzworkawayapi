<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StartServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the server';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $port = env('PORT', 5000);
        $this->info("Starting server on port $port...");
        // Ajoutez ici la logique pour démarrer votre serveur
        Log::info("Serveur en marche !!!");
    }
}
