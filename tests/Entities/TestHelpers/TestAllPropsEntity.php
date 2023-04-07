<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Attributes\PropertiesMustBeInitialised;
use Midnite81\Core\Attributes\PropertyName;
use Midnite81\Core\Entities\BaseEntity;

#[PropertiesMustBeInitialised]
class TestAllPropsEntity extends BaseEntity
{
    public string $title;

    public string $description;

    #[PropertyName('preview')]
    public string $content;

    protected string $id;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): TestAllPropsEntity
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): TestAllPropsEntity
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): TestAllPropsEntity
    {
        $this->content = $content;

        return $this;
    }
}
