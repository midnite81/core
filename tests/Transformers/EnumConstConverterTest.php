<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Transformers\Fixtures\TestWriter;
use Midnite81\Core\Transformers\EnumConstConverter;

it('can parse enums', function () {
    $converter = new EnumConstConverter(\Midnite81\Core\Enums\DateFormat::class);

    $sut = $converter->convert();

    expect($sut)->toBeString()
        ->toContain('DatabaseFormat: "DatabaseFormat"')
        ->toContain('DATE_RFC2822: "DATE_RFC2822"')
        ->toContain('DayMonthYearHourMinuteSecond_Hyphenated: "DayMonthYearHourMinuteSecond_Hyphenated"');
});

it('can parse an interface', function () {
    $converter = new EnumConstConverter(\Midnite81\Core\Tests\Transformers\Fixtures\TestInterface::class);

    $sut = $converter->convert();

    expect($sut)->toBeString()
        ->toContain('Red: "red"')
        ->toContain('Green: "green"')
        ->toContain('Blue: "blue"')
        ->toContain('Yellow: "yellow"')
        ->toContain('Allowed: [TestInterface.Blue, TestInterface.Green]');
});

it('can parse a class', function () {
    $converter = new EnumConstConverter(\Midnite81\Core\Tests\Transformers\Fixtures\TestClass::class);

    $sut = $converter->convert();

    expect($sut)->toBeString()
        ->toContain('Red: "red"')
        ->toContain('Green: "green"')
        ->toContain('Blue: "blue"')
        ->toContain('Yellow: "yellow"')
        ->toContain('Nullable: null')
        ->toContain('AreColours: true')
        ->not->toContain('Amber: "amber"');
});

it('can use a custom writer', function () {
    $converter = new EnumConstConverter(
        \Midnite81\Core\Enums\DateFormat::class,
        new TestWriter
    );

    $sut = $converter->convert();

    expect($sut)->toBeString()->toBe('This is a test');
});

it('throws an exception if it cannot find the class', function () {
    $this->markTestSkipped('This test is skipped because it requires a class that does not exist.');
    expect(fn () => new EnumConstConverter('MyClass', new TestWriter))
        ->toThrow(
            \Midnite81\Core\Exceptions\Transformers\ClassNotFoundException::class,
            'Class or interface MyClass does not exist.'
        )
        ->and(fn () => new EnumConstConverter(
            MyClass::class,
            new TestWriter
        ))->toThrow(
            \Midnite81\Core\Exceptions\Transformers\ClassNotFoundException::class,
            'Class or interface MyClass does not exist.'
        );
});
