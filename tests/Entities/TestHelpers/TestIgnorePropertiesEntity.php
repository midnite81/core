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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): TestIgnorePropertiesEntity
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): TestIgnorePropertiesEntity
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): TestIgnorePropertiesEntity
    {
        $this->age = $age;

        return $this;
    }
}
