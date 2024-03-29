<?php

namespace Midnite81\Core\Commands\Database;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Midnite81\Core\Commands\Traits\FailureProcessing;
use Midnite81\Core\Contracts\Services\ExecuteInterface;

class BackupDatabase extends Command
{
    use FailureProcessing;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup
                           {connection? : The connection you want to backup}
                           {--directory= : The directory in the storage folder you want to save to}
                           {--chmod= : The chmod for any directories created e.g 0777, defaults to 0777}
                           {--abs : This option allows you to specify any directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backs up the database';

    protected ?string $directory;

    protected string $baseName;

    protected string $extension;

    protected string $timestamp;

    protected string $filename;

    protected string $filePath;

    public function __construct(protected ExecuteInterface $execute)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $connectionName = $this->getConnectionName();
        $connection = config('database.connections.' . $connectionName);

        if (empty($connection)) {
            return $this->failure('Connection not found');
        }

        if ($connection['driver'] != 'mysql') {
            return $this->failure('Can only backup MYSQL databases');
        }

        $command = $this->makeCommand($connection, $connectionName);

        try {
            $this->execute->exec($command);
            $this->line("Database backed up to {$this->filePath}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            return $this->failure($e);
        }
    }

    /**
     * Make the database command
     */
    protected function makeCommand($connection, $connectionName): string
    {
        $username = escapeshellarg($connection['username']);
        $password = escapeshellarg($connection['password']);
        $database = escapeshellarg($connection['database']);
        $host = escapeshellarg($connection['host']);
        $port = !empty($connection['port']) ? escapeshellarg($connection['port']) : '3306';
        $filename = escapeshellarg($this->filename($connectionName));

        return "mysqldump -u $username --password=$password $database -h $host -P $port > $filename";
    }

    /**
     * Creates directory if it doesn't exist and returns a filename to write backup to
     */
    public function filename(string $connectionName): string
    {
        $directory = $this->option('abs')
            ? realpath($this->option('directory') ?? '')
            : realpath(storage_path($this->option('directory') ?? ''));

        if (!empty($directory) && !is_dir($directory)) {
            mkdir($directory, $this->option('chmod', '0777'), true);
        }

        $this->directory = is_string($directory) ? $directory : null;
        $this->baseName = Str::slug($connectionName);
        $this->extension = 'sql';
        $this->timestamp = Carbon::now()->format('Y-m-d-H-i-s');
        $this->filename = "{$this->baseName}-{$this->timestamp}.{$this->extension}";
        $this->filePath = "$directory" . DIRECTORY_SEPARATOR . "$this->filename";

        return $this->filePath;
    }

    /**
     * Get the connection name
     */
    protected function getConnectionName(): string
    {
        if (!empty($this->argument('connection')) && $this->argument('connection') != 'null') {
            return $this->argument('connection');
        }

        return config('database.default');
    }
}
