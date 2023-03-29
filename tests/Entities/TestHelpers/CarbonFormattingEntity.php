<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Carbon\Carbon;
use Midnite81\Core\Attributes\CarbonFormat;
use Midnite81\Core\Entities\BaseEntity;

class CarbonFormattingEntity extends BaseEntity
{
    #[CarbonFormat('d/m/Y')]
    public Carbon $dateOfBirth;

    #[CarbonFormat('d M Y')]
    public Carbon $someOtherDate;
}
