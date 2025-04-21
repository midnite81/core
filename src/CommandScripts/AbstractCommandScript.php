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
     *
     * @throws CommandFailedException
     */
    abstract public function handle(FireScriptsCommand $command, ExecuteInterface $execute): int;

    /**
     * This script extension should announce itself before running
     *
     * @return $this
     */
    public function shouldAnnounce(): static
    {
        $this->shouldAnnounce = true;

        return $this;
    }

    /**
     * This script extension should not announce itself before running
     *
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
     *
     * @return $this
     */
    public function withMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Serialise Magic Method
     */
    public function __serialize(): array
    {
        return [
            'shouldAnnounce' => $this->shouldAnnounce,
            'message' => $this->message,
        ];
    }

    /**
     * Unserialise Magic Method
     */
    public function __unserialize(array $data): void
    {
        $this->shouldAnnounce = $data['shouldAnnounce'];
        $this->message = $data['message'];
    }

    /**
     * Set State Magic Method
     */
    public static function __set_state(array $data): object
    {
        $class = new static;
        $class->shouldAnnounce = $data['shouldAnnounce'];
        $class->message = $data['message'];

        return $class;
    }
}
