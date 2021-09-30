<?php

namespace R4nkt\LaravelR4nkt\Commands;

use Illuminate\Console\Command;

class LaravelR4nktCommand extends Command
{
    public $signature = 'laravel-r4nkt-sdk';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
