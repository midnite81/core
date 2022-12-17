<?php

declare(strict_types=1);

use Midnite81\Core\Exceptions\Entities\PropertyIsRequiredException;
use Midnite81\Core\Tests\Entities\TestHelpers\RequiredPropertiesEntity;

it('throws an error if a required property is not filled or initialised', function () {
    $entity = new RequiredPropertiesEntity();

    expect(fn () => $entity->toArray())
        ->toThrow(
            PropertyIsRequiredException::class,
            'The property [name] is required'
        );
});

it('throws an error if a second required property is not filled or initialised', function () {
    $entity = new RequiredPropertiesEntity();
    $entity->name = 'Dave';

    expect(fn () => $entity->toArray())
        ->toThrow(
            PropertyIsRequiredException::class,
            'The property [age] is required'
        );
});

it('does not throw an error if all required items are filled', function () {
    $entity = new RequiredPropertiesEntity();
    $entity->name = 'Dave';
    $entity->username = 'Dave123';
    $entity->setAge(23);

    expect($entity->toArray())
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['name', 'username']);
});

it('throws when using other output methods', function () {
    $entity = new RequiredPropertiesEntity();

    expect(fn () => $entity->toJson())
        ->toThrow(
            PropertyIsRequiredException::class,
            'The property [name] is required'
        )
        ->and(fn () => $entity->toLimitedArray(['name']))
        ->toThrow(
            PropertyIsRequiredException::class,
            'The property [name] is required'
        )
        ->and(fn () => $entity->getInitialisedProperties())
        ->toThrow(
            PropertyIsRequiredException::class,
            'The property [name] is required'
        );
});
