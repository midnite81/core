<?php

namespace Midnite81\Core\Commands\Environments;

use Illuminate\Console\Command;

class GetEnvironmentVariable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:get
                            {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets a value in the .env';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info(env($this->argument('key')));

        return Command::SUCCESS;
    }
}
