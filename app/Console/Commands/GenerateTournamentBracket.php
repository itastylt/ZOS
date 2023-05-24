<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TournamentBracketController;

class GenerateTournamentBracket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generateBracket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates tournament bracket';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new TournamentBracketController();
        $controller->startGeneration();
    }
}
