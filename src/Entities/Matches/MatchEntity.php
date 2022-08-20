<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Matches;

use Illuminate\Support\Collection;
use Midnite81\Core\Entities\BaseEntity;

class MatchEntity extends BaseEntity
{
    public function __construct(
        public readonly bool $matched,
        public readonly Collection $matches
    ) {
        parent::__construct();
    }
}
