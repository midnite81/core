<?php

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
