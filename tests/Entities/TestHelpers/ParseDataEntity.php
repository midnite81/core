<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Entities\BaseEntity;

class ParseDataEntity extends BaseEntity
{
    public function parse($data, $expectedResponse): object|array|string
    {
        return parent::parseData($data, $expectedResponse);
    }
}
