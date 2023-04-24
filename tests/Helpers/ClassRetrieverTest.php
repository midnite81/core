<?php

declare(strict_types=1);

it('retrieves the class properly', function () {
    $sut = \Midnite81\Core\Helpers\ClassRetriever::make(__DIR__ . '/Fixture/MyClass.php');

    expect($sut->name)->toBe('Midnite81\Core\Tests\Helpers\Fixture\MyClass')
        ->and($sut->type)->toBe('class')
        ->and($sut->extends)->toBe('Midnite81\Core\Tests\Helpers\Fixture\MyParentClass')
        ->and($sut->implements)->toBe(['Midnite81\Core\Tests\Helpers\Fixture\MyInterface'])
        ->and($sut->traits)->toBe(['Midnite81\Core\Tests\Helpers\Fixture\MyTrait']);
});

it('retrieves the interface properly', function () {
    $sut = \Midnite81\Core\Helpers\ClassRetriever::make(__DIR__ . '/Fixture/MyInterface.php');

    expect($sut->name)->toBe('Midnite81\Core\Tests\Helpers\Fixture\MyInterface')
        ->and($sut->type)->toBe('interface')
        ->and($sut->extends)->toBe('')
        ->and($sut->implements)->toBe([])
        ->and($sut->traits)->toBe([]);
});

it('retrieves the trait properly', function () {
    $sut = \Midnite81\Core\Helpers\ClassRetriever::make(__DIR__ . '/Fixture/MyTrait.php');

    expect($sut->name)->toBe('Midnite81\Core\Tests\Helpers\Fixture\MyTrait')
        ->and($sut->type)->toBe('trait')
        ->and($sut->extends)->toBe('')
        ->and($sut->implements)->toBe([])
        ->and($sut->traits)->toBe([]);
});
