<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities;

use Throwable;

class AttemptEntity extends BaseEntity
{
    public bool $successful = true;

    public bool $hasErrored = false;

    /**
     * @param mixed $result The result of the attempted closure, if it was successful
     * @param Throwable|null $throwable The throwable error if the closure has failed
     */
    public function __construct(
        public mixed $result = null,
        public ?Throwable $throwable = null
    ) {
        if ($this->throwable) {
            $this->successful = false;
            $this->hasErrored = true;
        }
        parent::__construct();
    }
}
