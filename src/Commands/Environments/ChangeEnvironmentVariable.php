<?php

namespace Midnite81\Core\Commands\Environments;

use Illuminate\Console\Command;
use Midnite81\Core\Commands\Traits\FailureProcessing;
use Midnite81\Core\Exceptions\General\FileNotFoundException;

class ChangeEnvironmentVariable extends Command
{
    use FailureProcessing;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set
                            {key}
                            {value?}
                            { --blank }
                            { --silent}';

    /**
     * The path to the env file
     *
     * @var string
     */
    protected string $environmentPath;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes a value in the .env';

    /**
     * Create a new command instance.
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
        try {
            $this->environmentPath = $this->getEnvironmentalFilePath();
        } catch (FileNotFoundException $e) {
            $this->failure(
                $e,
                'As the environmental file could not be found, use the file argument to specify the path to the file'
            );
        }

        if (!$this->proceedWhenInProduction()) {
            $this->info('The command has been cancelled as you are in production');

            return Command::SUCCESS;
        }

        if (empty($this->getValue()) && !$this->option('blank')) {
            return $this->failure('You cannot set a blank value unless you pass the --blank option');
        }

        $envFile = $this->loadEnvironmentalFile();

        if ($this->keyExists($this->argument('key'), $envFile)) {
            $this->warn("You are changing {$this->getKey()} from {$this->getEnvKey()} to {$this->getValue()}");
            $env = $this->updateEnvKeyPair($envFile);
        } else {
            $env = $this->createEnvKeyPair($envFile);
        }

        $this->save($env);
        $this->info('The environmental file has been updated');

        return Command::SUCCESS;
    }

    /**
     * Gets and returns the env file
     *
     * @return bool|string
     */
    protected function loadEnvironmentalFile(): bool|string
    {
        $contents = file_get_contents($this->environmentPath);

        if ($contents === false) {
            $this->failure('The environmental file could not be loaded');
        }

        return $contents;
    }

    /**
     * Checks to see if the key exists in the passed data
     *
     * @param $argument
     * @param $envFile
     * @return int
     */
    protected function keyExists($argument, $envFile): int
    {
        return preg_match('/^' . $argument . '=/mi', $envFile);
    }

    /**
     * Updates an Environmental Key Pair
     *
     * @param $envFile
     * @return string
     */
    protected function updateEnvKeyPair($envFile): string
    {
        $pattern = '/^' . $this->argument('key') . '=(.*?)(\n??)$/mi';
        $replacement = $this->getKey() . '=' . $this->getValue();

        return preg_replace($pattern, $replacement, $envFile);
    }

    /**
     * Creates an Environmental Key Pair
     *
     * @param $envFile
     * @return string
     */
    protected function createEnvKeyPair($envFile): string
    {
        $addition = "\n{$this->getKey()}={$this->getValue()}\n";

        return $envFile . $addition;
    }

    /**
     * Saves the env file
     *
     * @param string $contents
     * @return bool|int
     */
    protected function save(string $contents): bool|int
    {
        $save = file_put_contents($this->environmentPath, $contents);

        if ($save === false) {
            $this->failure('The environmental file could not be saved');
        }

        return $save;
    }

    /**
     * Get the key
     *
     * @return string
     */
    protected function getKey(): string
    {
        return strtoupper($this->argument('key'));
    }

    /**
     * Get the value
     *
     * @return array|string
     */
    protected function getValue(): array|string
    {
        $value = $this->argument('value');

        if (preg_match("/(\s)+/si", $value)) {
            return '"' . $value . '"';
        } else {
            return $value;
        }
    }

    /**
     * Check to see if the application should proceed
     *
     * @return bool
     */
    protected function proceedWhenInProduction(): bool
    {
        if (config('app.environment', 'production') === 'production' && !$this->option('silent')) {
            $this->warn('Application is in production!');
            $confirmation = $this->ask('Are you sure you want to continue? (y/n)', 'n');

            if (!in_array(strtolower($confirmation), ['y', 'yes'])) {
                $this->info('Abandoned change');

                return false;
            }
        }

        return true;
    }

    /**
     * Get Env Key
     *
     * @return mixed|string
     */
    protected function getEnvKey(): mixed
    {
        /** @noinspection LaravelFunctionsInspection */
        $envKey = env($this->getKey());

        if (is_bool($envKey)) {
            return ($envKey) ? 'true' : 'false';
        }

        return $envKey;
    }

    /**
     * Finds the environmental file path
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    protected function getEnvironmentalFilePath(): string
    {
        if (method_exists(app(), 'environmentFile') && method_exists(app(), 'environmentPath')) {
            return $this->find(app()->environmentPath() . DIRECTORY_SEPARATOR . app()->environmentFile());
        }

        if (method_exists(app(), 'environmentFilePath')) {
            return $this->find(app()->environmentFilePath());
        }

        return $this->find(base_path('.env'));
    }

    /**
     * @param string $path
     * @return string
     *
     * @throws FileNotFoundException
     */
    protected function find(string $path): string
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("File does not exist at path {$path}");
        }

        return $path;
    }
}
