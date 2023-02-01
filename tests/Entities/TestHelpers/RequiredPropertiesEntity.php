<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Attributes\RequiredProperty;
use Midnite81\Core\Entities\BaseEntity;

class RequiredPropertiesEntity extends BaseEntity
{
    #[RequiredProperty]
    public string $name;

    public string $username;

    #[RequiredProperty]
    private int $age;

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return RequiredPropertiesEntity
     */
    public function setAge(int $age): RequiredPropertiesEntity
    {
        $this->age = $age;

        return $this;
    }
}
