<?php

use Midnite81\Core\Exceptions\Entities\PropertiesMustBeInitialisedException;
use Midnite81\Core\Tests\Entities\TestHelpers\TestAllPropsEntity;

it('should ensure all properties are initialised', function () {
    $entity = (new TestAllPropsEntity())
        ->setTitle('my title')
        ->setDescription('my description')
        ->setContent('my content');

    expect($entity->getInitialisedProperties())
        ->toBeArray()
        ->toHaveCount(3);
});

it('should throw error when properties are not initialised', closure: function () {
    $entity = (new TestAllPropsEntity())
        ->setTitle('my title');

    expect(fn () => $entity->getInitialisedProperties())
        ->toThrow(
            PropertiesMustBeInitialisedException::class,
            'All public properties must be initialised on Midnite81\Core\Tests\Entities\TestHelpers\TestAllPropsEntity'
        );
});
