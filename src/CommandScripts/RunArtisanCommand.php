<?php

declare(strict_types=1);

namespace Midnite81\Core\CommandScripts;

class RunArtisanCommand
{
    public bool $shouldAnnounce = true;

    public ?string $message = null;

    public function __construct(
        public string $commandSignature,
        public array $argumentsAndOptions = []
    ) {
    }

    /**
     * If the script should announce itself, you can customise the message which is
     * sent to the user.
     *
     * @param string $message
     * @return $this
     */
    public function withMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * This will announce the script to the user and ask them to decide whether to run the command
     *
     * @return $this
     */
    public function shouldAnnounce(): static
    {
        $this->shouldAnnounce = true;

        return $this;
    }

    /**
     * This will provide no announcement of the script to the user; it will run
     * without needing them to confirm its execution
     *
     * @return $this
     */
    public function shouldNotAnnounce(): static
    {
        $this->shouldAnnounce = false;

        return $this;
    }
}
