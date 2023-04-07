<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Attributes\PropertyName;
use Midnite81\Core\Entities\BaseEntity;

class TestEntity extends BaseEntity
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

    public function setTitle(string $title): TestEntity
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): TestEntity
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): TestEntity
    {
        $this->content = $content;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): TestEntity
    {
        $this->id = $id;

        return $this;
    }
}
