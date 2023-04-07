<?php

declare(strict_types=1);

namespace Midnite81\Core\Transformers;

use RuntimeException;

class FileLimiter
{
    /**
     * The lines from the document
     *
     * @var array<int, array>
     */
    public array $lines = [];

    /**
     * File Resource
     *
     * @var resource|bool
     */
    protected mixed $fileResource;

    /**
     * The current reading index
     */
    protected int $index = 0;

    /**
     * Construct the class
     */
    public function __construct(
        public string $filename
    ) {
        if (!file_exists($this->filename)) {
            throw new RuntimeException('File could not be found');
        }
        $this->fileResource = fopen($this->filename, 'r');
        if (!is_resource($this->fileResource)) {
            throw new RuntimeException('File is not a resource');
        }
    }

    /**
     * Factory create
     */
    public static function make(string $filename): static
    {
        return new static($filename);
    }

    /**
     * Read the first n lines from the file
     *
     * @return $this
     */
    public function readFirstLines(int $numberOfLines = 5): self
    {
        $this->createLineIndex();
        $this->resetPointer();

        while (!feof($this->fileResource)) {
            $line = fgets($this->fileResource, 4096);
            if (count($this->lines[$this->index]) < $numberOfLines) {
                $this->lines[$this->index][] = $line;
            }
        }

        $this->incrementIndex();

        return $this;
    }

    /**
     * Read the last n lines from the file
     *
     * @return $this
     */
    public function readLastLines(int $numberOfLines = 5): self
    {
        $this->createLineIndex();
        $this->resetPointer();

        while (!feof($this->fileResource)) {
            $line = fgets($this->fileResource, 4096);
            $this->lines[$this->index][] = $line;
            if (count($this->lines[$this->index]) > $numberOfLines) {
                array_shift($this->lines[$this->index]);
            }
        }

        $this->incrementIndex();

        return $this;
    }

    /**
     * @return $this
     */
    public function readSpecificLines(array $lineNumbers): static
    {
        $this->createLineIndex();
        $this->resetPointer();
        $count = 1;
        while (!feof($this->fileResource)) {
            $line = fgets($this->fileResource, 4096);

            if (in_array($count, $lineNumbers)) {
                $this->lines[$this->index][] = $line;
            }
            $count++;
        }

        $this->incrementIndex();

        return $this;
    }

    protected function createLineIndex(): void
    {
        $this->lines[$this->index] = [];
    }

    protected function incrementIndex(): void
    {
        $this->index++;
    }

    protected function resetPointer(): void
    {
        fseek($this->fileResource, 0, SEEK_SET);
    }

    /**
     * Returns the class to a string
     */
    public function toString(): string
    {
        $outputArray = [];
        foreach ($this->lines as $lineGroup) {
            foreach ($lineGroup as $key => $value) {
                $outputArray[] = $value;
            }
        }

        return implode('', $outputArray);
    }

    /**
     * Output the class to an array
     */
    public function toArray(): array
    {
        $outputArray = [];
        foreach ($this->lines as $lineGroup) {
            foreach ($lineGroup as $key => $value) {
                $outputArray[] = $value;
            }
        }

        return $outputArray;
    }

    /**
     * Return class to json object
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toFile(string $filename): bool|int
    {
        return file_put_contents($filename, $this->toString());
    }

    /**
     * To string magic method
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Deconstruct the class
     */
    public function __destruct()
    {
        fclose($this->fileResource);
    }
}
