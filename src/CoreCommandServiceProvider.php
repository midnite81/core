<?php

declare(strict_types=1);

namespace Midnite81\Core;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

class CoreCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $commandFiles = collect((new Filesystem())->allFiles(__DIR__ . '/Commands'));

            $commands = $commandFiles
                ->filter(function (SplFileInfo $fileInfo) {
                    return !str_contains($fileInfo->getRelativePathname(), 'Traits');
                })
                ->map(function (SplFileInfo $fileInfo) {
                    $file = $fileInfo->getRelativePathname();
                    $namespace = '\\Midnite81\\Core\\Commands';
                    if (dirname($file) !== '.') {
                        $namespace .= '\\' . str_replace('/', '\\', dirname($file));
                    }

                    return $namespace . '\\' . basename($file, '.php');
                });

            $this->commands($commands);
        }
    }
}
