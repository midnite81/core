<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Traits\Fixtures\TestEnum;

it('should convert enum to array', function () {
    $expectedResult = [
        'ONE' => 'Value 1',
        'TWO' => 'Value 2',
        'THREE' => 'Value 3',
    ];

    $result = \Midnite81\Core\Tests\Traits\Fixtures\TestEnum::toArray();

    expect($result)->toBe($expectedResult);
});

it('should convert enum to array with custom keys', function () {
    $expectedResult = [
        'One' => 'Value 1',
        'Two' => 'Value 2',
        'Three' => 'Value 3',
    ];

    $result = TestEnum::toArray(function ($caseName) {
        return ucfirst(strtolower($caseName));
    });

    expect($result)->toBe($expectedResult);
});
