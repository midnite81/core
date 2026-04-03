<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping;

use Midnite81\Core\Attributes\TrimStrings;
use Midnite81\Core\Entities\BaseEntity;
use Midnite81\Core\Exceptions\PropertyMappingException;

#[TrimStrings]
class TrimmedClassEntity extends BaseEntity
{
    public string $trimmed;

    public string $upperCaseString;

    /**
     * @param array|object $data
     *
     * @throws PropertyMappingException
     */
    public function __construct(array|object $data = [])
    {
        parent::__construct();
        $this->mapProperties($data);
    }

    public function definePropertyHandlers(): void
    {
        $this->propertyHandlers = [
            'upperCaseString' => fn ($value) => strtoupper($value),
        ];
    }
}
