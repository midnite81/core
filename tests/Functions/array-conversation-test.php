<?php

declare(strict_types=1);

use Illuminate\Contracts\Support\Arrayable;
use Midnite81\Core\Tests\CoreTestCase;
use function Midnite81\Core\Functions\toDeepArray;

uses(CoreTestCase::class);

it('handles simple arrays', function () {
    // Arrange
    $input = ['a' => 1, 'b' => 2, 'c' => 3];

    // Act
    $result = toDeepArray($input);

    // Assert
    expect($result)->toBe($input)
        ->and($result)->toBeArray();
});

it('handles nested arrays', function () {
    // Arrange
    $input = [
        'a' => 1,
        'b' => [
            'c' => 3,
            'd' => 4
        ],
        'e' => 5
    ];

    // Act
    $result = toDeepArray($input);

    // Assert
    expect($result)->toBe($input);
    expect($result)->toBeArray();
    expect($result['b'])->toBeArray();
});

it('handles collections', function () {
    // Arrange
    $collection = collect(['a' => 1, 'b' => 2, 'c' => 3]);

    // Act
    $result = toDeepArray($collection);

    // Assert
    expect($result)->toBe(['a' => 1, 'b' => 2, 'c' => 3]);
    expect($result)->toBeArray();
});

it('handles nested collections', function () {
    // Arrange
    $collection = collect([
        'a' => 1,
        'b' => collect(['c' => 3, 'd' => 4]),
        'e' => 5
    ]);

    // Act
    $result = toDeepArray($collection);

    // Assert
    $expected = [
        'a' => 1,
        'b' => ['c' => 3, 'd' => 4],
        'e' => 5
    ];
    expect($result)->toBe($expected);
    expect($result)->toBeArray();
    expect($result['b'])->toBeArray();
});

it('handles arrayable objects', function () {
    // Arrange
    $arrayable = new class implements Arrayable {
        public function toArray(): array
        {
            return ['a' => 1, 'b' => 2, 'c' => 3];
        }
    };

    // Act
    $result = toDeepArray($arrayable);

    // Assert
    expect($result)->toBe(['a' => 1, 'b' => 2, 'c' => 3]);
    expect($result)->toBeArray();
});

it('handles complex nested structures', function () {
    // Arrange
    $arrayable = new class implements Arrayable {
        public function toArray(): array
        {
            return ['x' => 10, 'y' => 20];
        }
    };

    $complex = [
        'a' => 1,
        'b' => collect([
            'c' => 3,
            'd' => $arrayable,
            'e' => collect(['f' => 6])
        ]),
        'g' => [
            'h' => 8,
            'i' => collect(['j' => 9])
        ]
    ];

    // Act
    $result = toDeepArray($complex);

    // Assert
    $expected = [
        'a' => 1,
        'b' => [
            'c' => 3,
            'd' => ['x' => 10, 'y' => 20],
            'e' => ['f' => 6]
        ],
        'g' => [
            'h' => 8,
            'i' => ['j' => 9]
        ]
    ];

    expect($result)->toBe($expected);
    expect($result)->toBeArray();
    expect($result['b'])->toBeArray();
    expect($result['b']['d'])->toBeArray();
    expect($result['b']['e'])->toBeArray();
    expect($result['g'])->toBeArray();
    expect($result['g']['i'])->toBeArray();
});

it('keeps scalar values untouched', function () {
    // Test with string
    expect(toDeepArray('test'))->toBe('test');

    // Test with integer
    expect(toDeepArray(123))->toBe(123);

    // Test with float
    expect(toDeepArray(123.45))->toBe(123.45);

    // Test with boolean
    expect(toDeepArray(true))->toBeTrue();
    expect(toDeepArray(false))->toBeFalse();

    // Test with null
    expect(toDeepArray(null))->toBeNull();
});

