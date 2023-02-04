<?php

declare(strict_types=1);

namespace Midnite81\Core\CommandScripts;

use Midnite81\Core\Commands\Development\FireScriptsCommand;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Exceptions\Commands\Development\CommandFailedException;

abstract class AbstractCommandScript
{
    public bool $shouldAnnounce = true;

    public ?string $message = null;

    /**
     * Handles the custom script
     *
     * @param FireScriptsCommand $command
     * @param ExecuteInterface $execute
     * @return int
     *
     * @throws CommandFailedException
     */
    abstract public function handle(FireScriptsCommand $command, ExecuteInterface $execute): int;

    /**
     * This script extension should announce itself before running
     * @return $this
     */
    public function shouldAnnounce(): static
    {
        $this->shouldAnnounce = true;
        return $this;
    }

    /**
     * This script extension should not announce itself before running
     * @return $this
     */
    public function shouldNotAnnounce(): static
    {
        $this->shouldAnnounce = false;
        return $this;
    }

    /**
     * If the script should announce itself, you can customise the message which is
     * sent to the user.
     * @return $this
     */
    public function withMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }
}
