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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return TestEntity
     */
    public function setTitle(string $title): TestEntity
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return TestEntity
     */
    public function setDescription(string $description): TestEntity
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return TestEntity
     */
    public function setContent(string $content): TestEntity
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return TestEntity
     */
    public function setId(string $id): TestEntity
    {
        $this->id = $id;

        return $this;
    }
}
