<?php

namespace Midnite81\Core\Commands\Environments;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Midnite81\Core\Commands\Traits\FailureProcessing;

class CreateBlankCopyOfEnvironmentFile extends Command
{
    use FailureProcessing;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:copy {--fileName=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a blank copy of the live env';

    protected string $blankFilename = '.env.blank';

    /**
     * Create a new command instance.
     *
     * @param Application $app
     * @param Filesystem $files
     */
    public function __construct(
        protected Application $app,
        protected Filesystem $files
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        if ($file = $this->option('fileName')) {
            $this->blankFilename = $file;
        }

        $envFilePath = $this->app->environmentFilePath();

        if ($this->files->exists($envFilePath)) {
            $env = $this->files->get($envFilePath);
            $saveLocation = $this->app->environmentPath() . DIRECTORY_SEPARATOR . $this->blankFilename;

            $freshCopy = preg_replace('/=.*?[\n$]/', "=\n", $env);

            $this->files->put($saveLocation, $freshCopy);
            $this->info("Blank env stored at: {$saveLocation}");

            return Command::SUCCESS;
        } else {
            $this->failure("Cannot find the env file: {$this->app->environmentFilePath()}");

            return Command::FAILURE;
        }
    }
}
