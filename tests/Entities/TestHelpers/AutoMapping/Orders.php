<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping;

use Carbon\Carbon;
use Midnite81\Core\Entities\BaseEntity;

class Orders extends BaseEntity
{
    public string $orderNumber;

    public Carbon $orderDate;

    public function __construct(array $data = [])
    {
        parent::__construct();
        $this->mapProperties($data);
    }

    public function defineTypeHandlers(): void
    {
        $this->typeHandlers = [
            ...$this->scalarHandlers(),
            Carbon::class => fn ($value) => Carbon::parse($value),
        ];
    }
}
