<?php

declare(strict_types=1);

it('retrieves the class properly', function () {
    $sut = \Midnite81\Core\Helpers\ClassRetriever::make(__DIR__ . '/Fixtures/MyClass.php');

    expect($sut->name)->toBe('Midnite81\Core\Tests\Helpers\Fixtures\MyClass')
        ->and($sut->type)->toBe('class')
        ->and($sut->extends)->toBe('Midnite81\Core\Tests\Helpers\Fixtures\MyParentClass')
        ->and($sut->implements)->toBe(['Midnite81\Core\Tests\Helpers\Fixtures\MyInterface'])
        ->and($sut->traits)->toBe(['Midnite81\Core\Tests\Helpers\Fixtures\MyTrait'])
        ->and($sut->isAbstract)->toBe(false);
});

it('retrieves the abstract class properly', function () {
    $sut = \Midnite81\Core\Helpers\ClassRetriever::make(__DIR__ . '/Fixtures/MyParentClass.php');

    expect($sut->name)->toBe('Midnite81\Core\Tests\Helpers\Fixtures\MyParentClass')
        ->and($sut->type)->toBe('class')
        ->and($sut->extends)->toBe('')
        ->and($sut->implements)->toBe([])
        ->and($sut->traits)->toBe([])
        ->and($sut->isAbstract)->toBe(true);
});

it('retrieves the interface properly', function () {
    $sut = \Midnite81\Core\Helpers\ClassRetriever::make(__DIR__ . '/Fixtures/MyInterface.php');

    expect($sut->name)->toBe('Midnite81\Core\Tests\Helpers\Fixtures\MyInterface')
        ->and($sut->type)->toBe('interface')
        ->and($sut->extends)->toBe('')
        ->and($sut->implements)->toBe([])
        ->and($sut->traits)->toBe([])
        ->and($sut->isAbstract)->toBe(false);
});

it('retrieves the trait properly', function () {
    $sut = \Midnite81\Core\Helpers\ClassRetriever::make(__DIR__ . '/Fixtures/MyTrait.php');

    expect($sut->name)->toBe('Midnite81\Core\Tests\Helpers\Fixtures\MyTrait')
        ->and($sut->type)->toBe('trait')
        ->and($sut->extends)->toBe('')
        ->and($sut->implements)->toBe([])
        ->and($sut->traits)->toBe([])
        ->and($sut->isAbstract)->toBe(false);
});
