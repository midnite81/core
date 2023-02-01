<?php

declare(strict_types=1);

namespace Midnite81\Core;

use Illuminate\Support\ServiceProvider;

class CoreCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    /**
     * Registers commands
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        $commands = array_merge(
            glob(__DIR__ . '/Commands/*.php'),
            glob(__DIR__ . '/Commands/**/*.php')
        );

        foreach ($commands as $command) {
            $commandClass = str_replace(
                [__DIR__ . '/', '/', '.php'],
                ['', '\\', ''],
                $command
            );
            $commandClass = 'Midnite81\\Core\\' . $commandClass;
            if (class_exists($commandClass)) {
                $command = app($commandClass);
                $this->commands($command);
            }
        }
    }
}
