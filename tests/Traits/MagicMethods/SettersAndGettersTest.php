<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Traits\Fixtures\GettersAndSetters;

it('can get and set', function () {
    $gettersAndSetters = new GettersAndSetters;

    expect($gettersAndSetters->getName())
        ->toBe('Ben')
        ->and($gettersAndSetters->getAge())->toBe(30)
        ->and($gettersAndSetters->age = 29)->toBe(29)
        ->and($gettersAndSetters->setAge(31))->toBeInstanceOf(GettersAndSetters::class)
        ->and($gettersAndSetters->getAge())->toBe(31)
        ->and($gettersAndSetters->setName('Bob'))->toBeInstanceOf(GettersAndSetters::class)
        ->and($gettersAndSetters->getName())->toBe('Bob');
});
