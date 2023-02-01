<?php

namespace Midnite81\Core\Commands\Development;

use Illuminate\Console\Command;

class QuickFireScriptCommand extends Command
{
    protected $signature = 'scripts:quick {scriptsName}';

    protected $description = 'Speedy way to run run:scripts with a script option';

    public function handle(): int
    {
        return $this->call('run:scripts', [
            '--script', $this->argument('scriptsName')
        ]);
    }
}
