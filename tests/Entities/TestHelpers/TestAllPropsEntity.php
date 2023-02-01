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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return TestAllPropsEntity
     */
    public function setTitle(string $title): TestAllPropsEntity
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
     * @return TestAllPropsEntity
     */
    public function setDescription(string $description): TestAllPropsEntity
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
     * @return TestAllPropsEntity
     */
    public function setContent(string $content): TestAllPropsEntity
    {
        $this->content = $content;

        return $this;
    }
}
