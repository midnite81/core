<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities;

use Throwable;

class AttemptEntity extends BaseEntity
{
    /**
     * @param  mixed  $result
     * @param  Throwable|null  $throwable
     */
    public function __construct(public mixed $result = null, public ?Throwable $throwable = null)
    {
        parent::__construct();
    }
}
