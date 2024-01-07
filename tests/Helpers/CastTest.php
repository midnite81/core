<?php

declare(strict_types=1);

use Midnite81\Core\Helpers\Cast;

it('casts to number from string', function () {
    $sut1 = Cast::to('123', 'int');
    expect($sut1)->toBe(123)->toBeInt();

    $sut2 = (new Cast())->to('123', 'int');
    expect($sut2)->toBe(123)->toBeInt();
});

it('casts to string from number', function () {
    $sut1 = Cast::to(123, 'string');
    expect($sut1)->toBe('123')->toBeString();

    $sut2 = (new Cast())->to(123, 'string');
    expect($sut2)->toBe('123')->toBeString();
});

it('casts to bool from string', function () {
    $sut1 = Cast::to('true', 'bool');
    expect($sut1)->toBe(true)->toBeBool();

    $sut2 = (new Cast())->to('true', 'bool');
    expect($sut2)->toBe(true)->toBeBool();

});

it('casts to bool from number', function () {
    $sut1 = Cast::to(1, 'bool');
    expect($sut1)->toBe(true)->toBeBool();

    $sut2 = (new Cast())->to(1, 'bool');
    expect($sut2)->toBe(true)->toBeBool();
});

it('casts to array from object', function () {
    $object = new stdClass();
    $object->name = 'test';

    $sut1 = Cast::to($object, 'array');
    expect($sut1)->toBeArray()->toBe(['name' => 'test']);

    $sut2 = (new Cast())->to($object, 'array');
    expect($sut2)->toBeArray()->toBe(['name' => 'test']);
});

it('casts to object from array', function () {
    $array = ['name' => 'test'];

    $sut1 = Cast::to($array, 'object');
    expect($sut1)->toBeObject()->toBeInstanceOf(stdClass::class);

    $sut2 = (new Cast())->to($array, 'object');
    expect($sut2)->toBeObject()->toBeInstanceOf(stdClass::class);
});

it('casts to float from string', function () {
    $sut1 = Cast::to('1.23', 'float');
    expect($sut1)->toBeFloat()->toBe(1.23);

    $sut2 = (new Cast())->to('1.23', 'float');
    expect($sut2)->toBeFloat()->toBe(1.23);
});

it('casts to float from int', function () {
    $sut1 = Cast::to(1, 'float');
    expect($sut1)->toBeFloat()->toBe(1.0);

    $sut2 = (new Cast())->to(1, 'float');
    expect($sut2)->toBeFloat()->toBe(1.0);
});

it('casts to string from float', function () {
    $sut1 = Cast::to(1.23, 'string');
    expect($sut1)->toBeString()->toBe('1.23');

    $sut2 = (new Cast())->to(1.23, 'string');
    expect($sut2)->toBeString()->toBe('1.23');
});

it('casts to int from float', function () {
    $sut1 = Cast::to(1.23, 'int');
    expect($sut1)->toBeInt()->toBe(1);

    $sut2 = (new Cast())->to(1.23, 'int');
    expect($sut2)->toBeInt()->toBe(1);
});

it('if value is empty it will not try to cast', function () {
    $sut1 = Cast::castIfNotEmpty(null, 'int');
    expect($sut1)->toBeNull();

    $sut2 = Cast::castIfNotEmpty('0', 'int');
    expect($sut2)->tobe('0')->toBeString();

    $sut3 = (new Cast)->castIfNotEmpty(null, 'int');
    expect($sut3)->toBeNull();

    $sut4 = (new Cast)->castIfNotEmpty('0', 'int');
    expect($sut4)->tobe('0')->toBeString();
});

it('null if empty', function () {
    $sut1 = Cast::nullIfEmpty('  ');
    expect($sut1)->toBeNull();

    $sut2 = (new Cast())->nullIfEmpty('  ');
    expect($sut2)->toBeNull();
});
