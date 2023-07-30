<?php

declare(strict_types=1);

use Midnite81\Core\Enums\ExpectedType;
use Midnite81\Core\Tests\Entities\TestHelpers\ParseDataEntity;

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('creates from object to object', function () {
    $entity = new ParseDataEntity();
    $data = (object)['name' => 'John', 'age' => 30];
    $expectedResponse = ExpectedType::Object;

    expect($data)->toBe($entity->parse($data, $expectedResponse))
                 ->and($entity->parse($data, $expectedResponse))->toBeObject();
});

it('creates from array to array', function () {
    $entity = new ParseDataEntity();
    $data = ['apple', 'banana', 'orange'];
    $expectedResponse = ExpectedType::Object;

    expect($data)->toBe($entity->parse($data, $expectedResponse))
                 ->and($entity->parse($data, $expectedResponse))->toBeArray();
});

it('creates from string to string', function () {
    $entity = new ParseDataEntity();
    $data = '{"name":"Alice","age":25}';
    $expectedResponse = ExpectedType::String;

    expect($data)->toBe($entity->parse($data, $expectedResponse))
                 ->and($entity->parse($data, $expectedResponse))->toBeString();
});


it('creates from string to object', function () {
    $entity = new ParseDataEntity();
    $data = '{"name":"Bob","age":35}';
    $expectedResponse = ExpectedType::Object;

    $parsed = $entity->parse($data, $expectedResponse);
    expect($parsed->name)
        ->toBe('Bob')
        ->and($parsed->age)->toBe(35)
        ->and($entity->parse($data, $expectedResponse))->toBeObject();
});

it('creates from string to array', function () {
    $entity = new ParseDataEntity();
    $data = ['name' => 'James', 'location' => 'UK'];
    $expectedResponse = ExpectedType::Array;

    $parsed = $entity->parse($data, $expectedResponse);
    expect($parsed['name'])
        ->toBe('James')
        ->and($parsed['location'])->toBe('UK')
        ->and($parsed)->toBeArray();
});

it('creates from array to string', function () {
    $entity = new ParseDataEntity();
    $data = ['name' => 'Dave', 'age' => 23, 'location' => 'UK'];
    $expectedResponse = ExpectedType::String;

    $parsed = $entity->parse($data, $expectedResponse);
    expect($parsed)->toBe('{"name":"Dave","age":23,"location":"UK"}')
                   ->and($parsed)->toBeString();
});

it('creates from object to string', function () {
    $entity = new ParseDataEntity();
    $data = (object)['name' => 'Dave', 'age' => 23, 'location' => 'UK'];
    $expectedResponse = ExpectedType::String;

    $parsed = $entity->parse($data, $expectedResponse);
    expect($parsed)->toBe('{"name":"Dave","age":23,"location":"UK"}')
                   ->and($parsed)->toBeString();
});

it('creates from object to array', function () {
    $entity = new ParseDataEntity();
    $data = (object)['name' => 'Dave', 'age' => 23, 'location' => 'UK'];
    $expectedResponse = ExpectedType::Array;

    $parsed = $entity->parse($data, $expectedResponse);
    expect($parsed['name'])
        ->toBe('Dave')
        ->and($parsed['age'])->toBe(23)
        ->and($parsed['location'])->toBe('UK')
        ->and($parsed)->toBeArray();
});
