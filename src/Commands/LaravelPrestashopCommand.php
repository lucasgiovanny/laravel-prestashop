<?php

namespace Lucasgiovanny\LaravelPrestashop\Commands;

use Illuminate\Console\Command;

class LaravelPrestashopCommand extends Command
{
    public $signature = 'laravel-prestashop';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
