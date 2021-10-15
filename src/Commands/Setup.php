<?php

declare(strict_types=1);

namespace Meetjet\LaravelCentrifugo\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'centrifugo:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup local Centrifugo Server With Laravel Sail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        File::copy(__DIR__ . "/../../stubs/centrifugo.json", base_path('centrifugo.json'));
        return Command::SUCCESS;
    }
}
