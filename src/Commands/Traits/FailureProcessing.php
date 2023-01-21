<?php

declare(strict_types=1);

namespace Midnite81\Core\Commands\Traits;

use Illuminate\Console\Command;

trait FailureProcessing
{
    /**
     * Displays a message and ends the script with a failure status
     *
     * @param  \Exception|string  $error
     * @param  string  $resolution
     * @return int
     */
    protected function failure(
        \Exception|string $error = 'Something went wrong',
        string $resolution = ''
    ): int {
        $this->error('There was an error');
        if ($error instanceof \Exception) {
            $this->error('Message: ' . $error->getMessage());
            $this->error('Trace: ' . $error->getTraceAsString());
        } else {
            $this->error($error);
        }

        if (!empty($resolution)) {
            $this->error('>>>> To resolve this error, please try the following:');
            $this->error($resolution);
        }

        return Command::FAILURE;
    }
}
