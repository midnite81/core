<?php

/** @noinspection ALL */

declare(strict_types=1);

use Midnite81\Core\Exceptions\MagicMethods\PropertyRequiresCanSetViaMagicMethodAttributeException;

it('can set fluently', function () {
    $class = new class
    {
        use \Midnite81\Core\Traits\Entities\FluentSetters;

        public string $name;

        protected int $age;

        #[\Midnite81\Core\Attributes\MagicMethods\Setters\CannotBeSetByMagicMethod]
        private string $address = 'London';

        public function getAge()
        {
            return $this->age;
        }

        public function getAddress()
        {
            return $this->address;
        }
    };

    $class->name = 'John Doe';
    $class->age = 30;

    expect($class->name)
        ->toBe('John Doe')
        ->and($class->getAge())->toBe(30)
        ->and($class->getAddress())->toBe('London');
});

it('can not set address via magic method', function () {
    $class = new class
    {
        use \Midnite81\Core\Traits\Entities\FluentSetters;

        public string $name;

        protected int $age;

        #[\Midnite81\Core\Attributes\MagicMethods\Setters\CannotBeSetByMagicMethod]
        private string $address = 'London';

        public function getAge()
        {
            return $this->age;
        }

        public function getAddress()
        {
            return $this->address;
        }
    };

    expect(fn () => $class->address = 'New York')
        ->toThrow(\Midnite81\Core\Exceptions\MagicMethods\CannotBeSetByMagicMethodException::class);
});

it('cannot set unless explicit', function () {
    $class = new \Midnite81\Core\Tests\Traits\Fixtures\ExplicitSetter();

    expect(fn () => $class->name = 'John Doe')
        ->toThrow(PropertyRequiresCanSetViaMagicMethodAttributeException::class)
        ->and(fn () => $class->age = 30)
        ->not()->toThrow(PropertyRequiresCanSetViaMagicMethodAttributeException::class)
        ->and(fn () => $class->setName('John Doe'))
        ->toThrow(PropertyRequiresCanSetViaMagicMethodAttributeException::class)
        ->and(fn () => $class->setAge(30))
        ->not()->toThrow(PropertyRequiresCanSetViaMagicMethodAttributeException::class);
});

it('throws if it doesnt know the setter', function () {
    $class = new class
    {
        use \Midnite81\Core\Traits\Entities\FluentSetters;

        public string $name;
    };

    expect(fn () => $class->setFullName('John Doe'))
        ->toThrow(\BadMethodCallException::class);
});
