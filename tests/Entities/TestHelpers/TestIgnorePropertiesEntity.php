<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Attributes\IgnoreProperty;
use Midnite81\Core\Entities\BaseEntity;

class TestIgnorePropertiesEntity extends BaseEntity
{
    #[IgnoreProperty]
    public int $id;

    public string $name;

    public int $age;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TestIgnorePropertiesEntity
     */
    public function setId(int $id): TestIgnorePropertiesEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TestIgnorePropertiesEntity
     */
    public function setName(string $name): TestIgnorePropertiesEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return TestIgnorePropertiesEntity
     */
    public function setAge(int $age): TestIgnorePropertiesEntity
    {
        $this->age = $age;

        return $this;
    }
}
