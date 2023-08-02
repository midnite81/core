<?php

declare(strict_types=1);

use Midnite81\Core\Attributes\MagicMethods\Getters\CannotGetByMagicMethod;
use Midnite81\Core\Exceptions\MagicMethods\CannotGetByMagicMethodException;
use Midnite81\Core\Tests\Traits\Fixtures\ExplicitGetter;
use Midnite81\Core\Traits\Entities\Getters;

beforeEach(function () {
    $this->class = new class
    {
        use Getters;

        protected string $name;

        #[CannotGetByMagicMethod]
        protected int $age;

        public function setName(string $name): void
        {
            $this->name = $name;
        }

        public function setAge(int $age): void
        {
            $this->age = $age;
        }
    };
});

it('can get property using magic getter', function () {
    $name = 'John';
    $this->class->setName($name);

    $result = $this->class->name;

    expect($result)->toBe($name);
});

it('throws exception when getting property without CanAccessViaMagicMethod attribute', function () {
    $age = 30;
    $this->class->setAge($age);

    expect(fn () => $this->class->age)
        ->toThrow(CannotGetByMagicMethodException::class)
        ->and(fn () => $this->class->getAge())
        ->toThrow(CannotGetByMagicMethodException::class);
});

it('throws an error if property name doesnt exist on magic call', function () {
    expect(fn () => $this->class->getDateOfBirth())
        ->toThrow(BadMethodCallException::class);
});

it('can only get specified props when Explicit is set', function () {
    $class = new ExplicitGetter();

    expect($class->name)
        ->toBe('John')
        ->and($class->getName())->toBe('John')
        ->and(fn () => $class->getAge())->toThrow(CannotGetByMagicMethodException::class)
        ->and(fn () => $class->age)->toThrow(CannotGetByMagicMethodException::class)
        ->and(fn () => $class->getLocation())->toThrow(CannotGetByMagicMethodException::class)
        ->and(fn () => $class->location)->toThrow(CannotGetByMagicMethodException::class);
});
