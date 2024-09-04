<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping;

use Midnite81\Core\Entities\BaseEntity;
use Midnite81\Core\Exceptions\PropertyMappingException;

class Address extends BaseEntity
{
    public string $line1;

    public string $line2;

    public string $line3;

    public string $town;

    public string $county;

    public string $postcode;

    /**
     * @param array $data
     *
     * @throws PropertyMappingException
     */
    public function __construct(array $data = [])
    {
        parent::__construct();
        $this->mapProperties($data);
    }
}
