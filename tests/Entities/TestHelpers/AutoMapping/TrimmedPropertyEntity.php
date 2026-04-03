<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping;

use Midnite81\Core\Attributes\TrimString;
use Midnite81\Core\Entities\BaseEntity;
use Midnite81\Core\Exceptions\PropertyMappingException;

class TrimmedPropertyEntity extends BaseEntity
{
    #[TrimString]
    public string $trimmed;

    public string $untouched;

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
}
