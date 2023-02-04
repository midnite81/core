<?php

namespace Midnite81\Core\Commands\Development;

use Illuminate\Console\Command;

class QuickFireScriptCommand extends Command
{
    /**
     * This will be overwritten on construct
     *
     * @var string
     */
    protected $signature = '';

    protected $description = 'Speedy way to run run:scripts with a script option';

    /**
     * The command name of this command
     *
     * @var string
     */
    protected string $commandName;

    public function __construct()
    {
        $this->commandName = config('core-ignition.quick-fire-script-command-name', 'scripts:quick');
        $this->signature = "{$this->commandName} {scriptsName} {args?* : This is the main argument passed to the command (used more in classes)}";
        parent::__construct();
    }

    public function handle(): int
    {
        return $this->call(config('core-ignition.fire-script-command-name', 'scripts:run'), [
            'args' => $this->argument('args'),
            '--script' => $this->argument('scriptsName'),
        ]);
    }
}
