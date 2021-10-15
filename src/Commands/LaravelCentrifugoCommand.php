<?php

namespace Meetjet\LaravelCentrifugo\Commands;

use Illuminate\Console\Command;

class LaravelCentrifugoCommand extends Command
{
    public $signature = 'laravel-centrifugo';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
