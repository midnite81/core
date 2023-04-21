<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Entities\TestHelpers\TestEntity;

it('can serialise the entity', function () {
    $entity = new TestEntity();
    $entity->title = 'My Book';
    $entity->description = 'My first ever book';

    $sut = serialize($entity);

    expect($sut)
        ->toBeString()
        ->not()->toThrow(Exception::class);
});

it('can un-serialise the entity', function () {
    $serialised = 'O:52:"Midnite81\Core\Tests\Entities\TestHelpers\TestEntity":2:{s:5:"title";s:7:"My Book";s:11:"description";s:18:"My first ever book";}';

    /** @var TestEntity $sut */
    $sut = unserialize($serialised);

    expect($sut)
        ->toBeInstanceOf(TestEntity::class)
        ->and($sut->getTitle())->toBe('My Book')
        ->and($sut->getDescription())->toBe('My first ever book')
        ->and($sut->getInitialisedProperties())->toHaveCount(2)->toBeArray();
});
