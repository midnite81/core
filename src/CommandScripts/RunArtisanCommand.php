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
    ) {}

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

    /**
     * Serialise Magic Method
     */
    public function __serialize(): array
    {
        return [
            'shouldAnnounce' => $this->shouldAnnounce,
            'message' => $this->message,
            'commandSignature' => $this->commandSignature,
            'argumentsAndOptions' => $this->argumentsAndOptions,
        ];
    }

    /**
     * Unserialise Magic Method
     */
    public function __unserialize(array $data): void
    {
        $this->shouldAnnounce = $data['shouldAnnounce'];
        $this->message = $data['message'];
        $this->commandSignature = $data['commandSignature'];
        $this->argumentsAndOptions = $data['argumentsAndOptions'];
    }

    /**
     * Set State Magic Method
     *
     * @return static
     */
    public static function __set_state($data)
    {
        $class = new static($data['commandSignature'], $data['argumentsAndOptions']);
        $class->shouldAnnounce = $data['shouldAnnounce'];
        $class->message = $data['message'];

        return $class;
    }
}
