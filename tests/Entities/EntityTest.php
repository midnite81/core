<?php

use Midnite81\Core\Exceptions\Entities\PropertyDoesNotExistException;
use Midnite81\Core\Exceptions\Entities\PropertyIsNotInitialisedException;
use Midnite81\Core\Exceptions\Entities\PropertyIsNotPublicException;
use Midnite81\Core\Tests\Entities\TestHelpers\TestEntity;

it('should get all initialised properties', function () {
    $entity = new TestEntity();
    $entity->title = 'My Book';
    $entity->description = 'My first ever book';

    expect($entity->getInitialisedProperties())
        ->toBeArray()
        ->toHaveCount(2)
        ->sequence(
            fn ($value, $key) => $key->toBe('title')->and($value->value)->toBe('My Book'),
            fn ($value, $key) => $key->toBe('description')->and($value->value)->toBe('My first ever book'),
        )
        ->not->toHaveKeys(['content', 'preview']);
});

it('should get renamed properties using attribute', function () {
    $entity = new TestEntity();
    $entity->content = 'This is my content';

    expect($entity->getInitialisedProperties())
        ->toBeArray()
        ->toHaveCount(1)
        ->sequence(
            fn ($value, $key) => $key->toBe('preview')->and($value->value)->toBe('This is my content'),
        )
        ->not->toHaveKeys(['content']);
});

it('should return an array', function () {
    $entity = new TestEntity();
    $entity->setId('102')
        ->setTitle('dave')
        ->setContent('This is my content')
        ->setDescription('This is my description');

    expect($entity->toArray())
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
            fn ($value, $key) => $key->toBe('title')->and($value->value)->toBe('dave'),
            fn ($value, $key) => $key->toBe('description')->and($value->value)->toBe('This is my description'),
            fn ($value, $key) => $key->toBe('preview')->and($value->value)->toBe('This is my content'),
        );
});

it('should not return nulls in an array', function () {
    $entity = new \Midnite81\Core\Tests\Entities\TestHelpers\NullPropertiesEntity();
    $entity->title = 'Null test';

    expect($entity->toArray(ignoreNulls: true))
        ->toBeArray()
        ->toHaveCount(1)
        ->not()->toHaveKey('description');
});

it('should limit an array to key passed', function () {
    $entity = new TestEntity();
    $entity->setId('102')
        ->setTitle('dave')
        ->setContent('This is my content')
        ->setDescription('This is my description');

    expect($entity->toLimitedArray(['preview']))
        ->toBeArray()
        ->toHaveCount(1)
        ->sequence(
            fn ($value, $key) => $key->toBe('preview')->and($value->value)->toBe('This is my content'),
        );
});

it('should pass full array if not limited', function () {
    $entity = new TestEntity();
    $entity->setId('102')
        ->setTitle('dave')
        ->setContent('This is my content')
        ->setDescription('This is my description');

    expect($entity->toLimitedArray([]))
        ->toBeArray()
        ->toHaveCount(3);
});

it('should exclude items from the array', function () {
    $entity = new TestEntity();
    $entity->setId('102')
        ->setTitle('dave')
        ->setContent('This is my content')
        ->setDescription('This is my description');

    expect($entity->toExcludedArray(['preview']))
        ->toBeArray()
        ->toHaveCount(2);
});

it('should return a json string', function () {
    $entity = new TestEntity();
    $entity->setId('102')
        ->setTitle('dave')
        ->setContent('This is my content')
        ->setDescription('This is my description');

    expect($entity->toJson())
        ->toBeString()
        ->toBe('{"title":"dave","description":"This is my description","preview":"This is my content"}');
});

it('should return a query string', function () {
    $entity = new TestEntity();
    $entity->setId('102')
        ->setTitle('dave')
        ->setContent('This is my content')
        ->setDescription('This is my description');

    expect($entity->toQueryString())
        ->toBeString()
        ->toBe('?title=dave&description=This+is+my+description&preview=This+is+my+content');
});

it('should return a limited query string', function () {
    $entity = new TestEntity();
    $entity->setId('102')
        ->setTitle('dave')
        ->setContent('This is my content')
        ->setDescription('This is my description');

    expect($entity->toQueryString(['title']))
        ->toBeString()
        ->toBe('?title=dave');
});

it('should be able to access properties as an array', function () {
    $entity = new TestEntity();
    $entity->setTitle('Hello')->setContent('This my content');

    expect($entity['title'])->toBe('Hello')
        ->and($entity['content'])->toBe('This my content');
});

it('should be not able to access properties as an array if they are not public', function () {
    $entity = new TestEntity();
    $entity->setId(23);

    expect(fn () => $entity['id'])->toThrow(
        PropertyIsNotPublicException::class,
        'Property [id] is not public'
    );
});

it('should be not able to access properties as an array if they are not initialised', function () {
    $entity = new TestEntity();

    expect(fn () => $entity['content'])->toThrow(
        PropertyIsNotInitialisedException::class,
        'Property [content] is not initialised'
    );
});

it('should be able to set properties as an array', function () {
    $entity = new TestEntity();
    $entity['title'] = 'Hello';
    $entity['content'] = 'This my content';

    expect($entity->getTitle())->toBe('Hello')
        ->and($entity->getContent())->toBe('This my content');
});

it('should be not able to set properties as an array if the property is not public', function () {
    $entity = new TestEntity();

    expect(fn () => $entity['id'] = 3)->toThrow(
        PropertyIsNotPublicException::class,
        'Property [id] is not public'
    );
});

it('should be not able to set properties as an array if the property does not exist', function () {
    $entity = new TestEntity();

    expect(fn () => $entity['full_name'] = 'Derek Johnson')->toThrow(
        PropertyDoesNotExistException::class,
        'Property [full_name] does not exist'
    );
});

it('should be able to unset properties as an array', function () {
    $entity = new TestEntity();
    $entity->setTitle('Hello')->setContent('This my content');

    expect($entity->getTitle())->toBe('Hello')
        ->and($entity->getContent())->toBe('This my content');

    unset($entity['title']);

    expect(fn () => $entity->getTitle())->toBeObject()
        ->and($entity->getContent())->toBe('This my content');
});

it('should find property by property name attribute via array accessor', function () {
    $entity = new TestEntity();
    $entity->content = 'This is my content';

    expect($entity['preview'])->toBe('This is my content');
});

it('should error when property not found via array accessor', function () {
    $entity = new TestEntity();
    $entity->content = 'This is my content';

    expect(fn () => $entity['non-existent-property'])->toThrow(
        PropertyDoesNotExistException::class,
        'Property [non-existent-property] does not exist'
    );
});

it('can determine if offset exists', function () {
    $entity = new TestEntity();
    $entity->content = 'This is my content';

    expect(isset($entity['preview']))->toBeTrue()
        ->and(isset($entity['non-existent-property']))->toBeFalse();
});
