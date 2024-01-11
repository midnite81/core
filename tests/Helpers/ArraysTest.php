<?php

use Midnite81\Core\Exceptions\Arrays\ArrayKeyAlreadyExistsException;
use Midnite81\Core\Helpers\Arrays;

it('filters array', function () {
    $array = [
        'first' => 'This is the first item',
        'second' => 'This is the second item',
        'third' => 'This is the third item',
        'fourth' => 'This is the fourth item',
    ];

    $sut = Arrays::filter($array, 'first');

    expect($sut)->toBeArray()->toHaveCount(1)->toHaveKey('first');
});

it("doesn't get case insensitive search", function () {
    $array = [
        'first' => 'This is the first item',
        'second' => 'This is the second item',
        'third' => 'This is the third item',
        'fourth' => 'This is the fourth item',
    ];

    $sut = Arrays::filter($array, 'this', ['caseSensitive' => true]);

    expect($sut)->toBeArray()->toHaveCount(0);
});

it("it negates what's found", function () {
    $array = [
        'first' => 'This is the first item',
        'second' => 'This is the second item',
        'third' => 'Hello! This is the third item',
        'fourth' => 'Hello! This is the fourth item',
    ];

    $sut = Arrays::filter($array, 'Hello', ['negate' => true]);

    expect($sut)->toBeArray()->toHaveCount(2)->toHaveKeys(['first', 'second']);
});

it('is case insensitive by default', function () {
    $array = [
        'first' => 'This is the first item',
        'second' => 'This is the second item',
        'third' => 'This is the third item',
        'fourth' => 'This is the fourth item',
    ];

    $sut = Arrays::filter($array, 'this');

    expect($sut)->toBeArray()->toHaveCount(4)->toHaveKeys(['first', 'second', 'third', 'fourth']);
});

it('it returns original value is empty', function () {
    $array = [
        'first' => 'This is the first item',
        'second' => 'This is the second item',
        'third' => 'This is the third item',
        'fourth' => 'This is the fourth item',
    ];

    $sut = Arrays::filter($array, useOriginalIfValueEmpty: true);

    expect($sut)->toBeArray()->toHaveCount(4)->toHaveKeys(['first', 'second', 'third', 'fourth']);
});

it("it doesn't returns original value is empty", function () {
    $array = [
        'first' => 'This is the first item',
        'second' => 'This is the second item',
        'third' => 'This is the third item',
        'fourth' => 'This is the fourth item',
    ];

    $sut = Arrays::filter($array);

    expect($sut)->toBeArray()->toHaveCount(0);
});

it('filters by key', function () {
    $array = [
        [
            'id' => 6,
            'name' => 'Sharon',
            'age' => 22,
        ],
        [
            'id' => 27,
            'name' => 'Bernard',
            'age' => 32,
        ],
        [
            'id' => 25,
            'name' => 'Trevor',
            'age' => 27,
        ],
    ];

    $sut = Arrays::filter($array, 'Trevor', filterKey: 'name');

    expect($sut)->toBeArray()->toHaveCount(1)
        ->and($sut[0]['id'])->toBe(25)
        ->and($sut[0]['name'])->toBe('Trevor')
        ->and($sut[0]['age'])->toBe(27);
});

it('preserves the key', function () {
    $array = [
        [
            'id' => 6,
            'name' => 'Sharon',
            'age' => 22,
        ],
        [
            'id' => 27,
            'name' => 'Bernard',
            'age' => 32,
        ],
        [
            'id' => 25,
            'name' => 'Trevor',
            'age' => 27,
        ],
    ];

    $sut = Arrays::filter(original: $array, value: 'Trevor', options: ['preserveKey' => true], filterKey: 'name');

    expect($sut)->toBeArray()->toHaveCount(1)->toHaveKey(2)
        ->and($sut[2]['id'])->toBe(25)
        ->and($sut[2]['name'])->toBe('Trevor')
        ->and($sut[2]['age'])->toBe(27);
});

it('returns the named keys', function () {
    $array = [
        'user1' => [
            'id' => 6,
            'name' => 'Sharon',
            'age' => 22,
        ],
        'user2' => [
            'id' => 27,
            'name' => 'Bernard',
            'age' => 32,
        ],
        'user3' => [
            'id' => 25,
            'name' => 'Trevor',
            'age' => 27,
        ],
    ];

    $sut = Arrays::filter(original: $array, value: 'Trevor', filterKey: 'name');

    expect($sut)->toBeArray()->toHaveCount(1)->toHaveKey('user3')
        ->and($sut['user3']['id'])->toBe(25)
        ->and($sut['user3']['name'])->toBe('Trevor')
        ->and($sut['user3']['age'])->toBe(27);
});

it('filters with integer values', function () {
    $array = [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
        ['id' => 3, 'name' => 'Charlie'],
    ];

    $sut = Arrays::filter($array, 2, filterKey: 'id');

    expect($sut)->toBeArray()->toHaveCount(1)
        ->and($sut[0])->toMatchArray(['id' => 2, 'name' => 'Bob']);
});

it('filters with boolean values', function () {
    $array = [
        ['id' => 1, 'name' => 'Alice', 'isActive' => true],
        ['id' => 2, 'name' => 'Bob', 'isActive' => false],
        ['id' => 3, 'name' => 'Charlie', 'isActive' => true],
    ];

    $sut = Arrays::filter($array, true, filterKey: 'isActive');

    expect($sut)->toBeArray()->toHaveCount(2)
        ->and($sut[0])->toMatchArray(['id' => 1, 'name' => 'Alice', 'isActive' => true])
        ->and($sut[1])->toMatchArray(['id' => 3, 'name' => 'Charlie', 'isActive' => true]);
});

it('handles an empty array', function () {
    $emptyArray = [];

    $sut = Arrays::filter($emptyArray, 'someValue');

    expect($sut)->toBeArray()->toBeEmpty();
});

it('handles non-existent filter key', function () {
    $array = [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
        ['id' => 3, 'name' => 'Charlie'],
    ];

    $sut = Arrays::filter($array, 'Alice', filterKey: 'nonExistentKey');

    expect($sut)->toBeArray()->toBeEmpty();
});

it('case sensitivity option with non-string values', function () {
    $array = [
        ['id' => 1, 'isActive' => true],
        ['id' => 2, 'isActive' => false],
        ['id' => 3, 'isActive' => true],
    ];

    $sut = Arrays::filter($array, true, ['caseSensitive' => true], filterKey: 'isActive');

    expect($sut)->toBeArray()->toHaveCount(2)
        ->and($sut[0])->toMatchArray(['id' => 1, 'isActive' => true])
        ->and($sut[1])->toMatchArray(['id' => 3, 'isActive' => true]);
});

it('combines negate and preserveKey options', function () {
    $array = [
        'user1' => ['id' => 1, 'name' => 'Alice'],
        'user2' => ['id' => 2, 'name' => 'Bob'],
        'user3' => ['id' => 3, 'name' => 'Charlie'],
    ];

    $sut = Arrays::filter($array, 'Bob', ['negate' => true, 'preserveKey' => true], 'name');

    expect($sut)->toBeArray()->toHaveCount(2)
        ->toHaveKey('user1')
        ->toHaveKey('user3');
});

it('filters with null value', function () {
    $array = [
        ['id' => 1, 'name' => 'Alice', 'nickname' => null],
        ['id' => 2, 'name' => 'Bob', 'nickname' => 'Bobby'],
        ['id' => 3, 'name' => 'Charlie', 'nickname' => null],
    ];

    $sut = Arrays::filter($array, null, filterKey: 'nickname');

    expect($sut)->toBeArray()->toHaveCount(2)
        ->and($sut[0])->toMatchArray(['id' => 1, 'name' => 'Alice', 'nickname' => null])
        ->and($sut[1])->toMatchArray(['id' => 3, 'name' => 'Charlie', 'nickname' => null]);
});

it('filters with empty string value', function () {
    $array = [
        ['id' => 1, 'name' => 'Alice', 'nickname' => ''],
        ['id' => 2, 'name' => 'Bob', 'nickname' => 'Bobby'],
        ['id' => 3, 'name' => 'Charlie', 'nickname' => ''],
    ];

    $sut = Arrays::filter($array, '', filterKey: 'nickname');

    expect($sut)->toBeArray()->toHaveCount(2)
        ->and($sut[0])->toMatchArray(['id' => 1, 'name' => 'Alice', 'nickname' => ''])
        ->and($sut[1])->toMatchArray(['id' => 3, 'name' => 'Charlie', 'nickname' => '']);
});

it('handles numeric string keys', function () {
    $array = [
        '1' => ['id' => 1, 'name' => 'Alice'],
        '2' => ['id' => 2, 'name' => 'Bob'],
        '3' => ['id' => 3, 'name' => 'Charlie'],
    ];

    $sut = Arrays::filter($array, 'Bob', filterKey: 'name');

    expect($sut)->toBeArray()->toHaveCount(1)
        ->toHaveKey('2')
        ->and($sut['2'])->toMatchArray(['id' => 2, 'name' => 'Bob']);
});

it('preserves non-numeric keys with preserveKey option', function () {
    $array = [
        'a' => ['id' => 1, 'name' => 'Alice'],
        'b' => ['id' => 2, 'name' => 'Bob'],
        'c' => ['id' => 3, 'name' => 'Charlie'],
    ];

    $sut = Arrays::filter($array, 'Bob', options: ['preserveKey' => true], filterKey: 'name');

    expect($sut)->toBeArray()->toHaveCount(1)
        ->toHaveKey('b')
        ->and($sut['b'])->toMatchArray(['id' => 2, 'name' => 'Bob']);
});

it('returns items that exactly match the given value with case sensitivity', function () {
    $input = ['Apple', 'Banana', 'apple', 'Orange'];
    $expected = ['Apple'];

    $result = Arrays::filter($input, 'Apple', ['fullMatch' => true, 'caseSensitive' => true]);

    expect($result)->toBe($expected);
});

it('returns items that exactly match the given value without case sensitivity', function () {
    $input = ['Apple', 'Banana', 'apple', 'Orange'];
    $expected = ['Apple', 'apple'];

    $result = Arrays::filter($input, 'Apple', ['fullMatch' => true, 'caseSensitive' => false]);

    expect($result)->toBe($expected);
});

it('works correctly with non-string values for full matching', function () {
    $input = [1, 2, '3', 4, 3];
    $expected = [3];

    $result = Arrays::filter($input, 3, ['fullMatch' => true]);

    expect($result)->toBe($expected);
});

it('returns an empty array if there are no exact matches', function () {
    $input = ['Apple', 'Banana', 'Orange'];
    $expected = [];

    $result = Arrays::filter($input, 'Pear', ['fullMatch' => true]);

    expect($result)->toBeEmpty();
});


it('filters array using case incentive method', function () {
    $array = [
        'first' => 'This is the first item',
        'second' => 'This is the second item',
        'third' => 'This is the third item',
        'fourth' => 'This is the fourth item',
    ];

    $sut = Arrays::filterInsensitive($array, 'this');
    $sut2 = Arrays::filterInsensitive($array, 'this', ['caseSensitive' => true]);

    expect($sut)->toBeArray()->toHaveCount(4)->toHaveKeys(['first', 'second', 'third', 'fourth'])
    ->and($sut2)->toBeArray()->toHaveCount(4)->toHaveKeys(['first', 'second', 'third', 'fourth']);
});

it('orders the array as specified', function () {
    $array = [
        [
            'id' => 6,
            'name' => 'Sharon',
            'age' => 22,
        ],
        [
            'id' => 27,
            'name' => 'Bernard',
            'age' => 32,
        ],
        [
            'id' => 25,
            'name' => 'Trevor',
            'age' => 27,
        ],
    ];

    $sut = Arrays::arrayOrderBy($array, 'name', SORT_ASC);

    expect($sut)
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
        /* @phpstan-ignore-next-line */
            fn ($value) => $value->name->toBe('Bernard'),
            /* @phpstan-ignore-next-line */
            fn ($value) => $value->name->toBe('Sharon'),
            /* @phpstan-ignore-next-line */
            fn ($value) => $value->name->toBe('Trevor'),
        );
});

it('adds and to an imploded array', function () {
    $sut = Arrays::implodeAnd(['one', 'two', 'three']);

    expect($sut)
        ->toBeString()
        ->toBe('one, two and three');
});

it('adds or to an imploded array', function () {
    $sut = Arrays::implodeOr(['one', 'two', 'three']);

    expect($sut)
        ->toBeString()
        ->toBe('one, two or three');
});

it('adds specified word to an imploded array', function () {
    $sut = Arrays::implodePenultimate(['one', 'two', 'three'], 'and/or');

    expect($sut)
        ->toBeString()
        ->toBe('one, two and/or three');
});

it('renames an array key', function () {
    $sutArray = [
        'name' => 'John',
        'age' => 32,
        'address' => '123 Fake Street',
    ];

    Arrays::renameKey($sutArray, 'name', 'first_name');

    expect($sutArray)
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKey('first_name')
        ->toHaveKey('age')
        ->toHaveKey('address')
        ->not->toHaveKey('name');
});

it('throws if array key exists already', function () {
    $sutArray = [
        'name' => 'John',
        'age' => 32,
        'address' => '123 Fake Street',
    ];

    expect(fn () => Arrays::renameKey($sutArray, 'age', 'name', true))
        ->toThrow(
            ArrayKeyAlreadyExistsException::class,
            'The key [name] already exists in the array'
        );
});

it('does not throw if array key exists already', function () {
    $sutArray = [
        'name' => 'John',
        'age' => 32,
        'address' => '123 Fake Street',
    ];

    Arrays::renameKey($sutArray, 'age', 'name', false);

    expect($sutArray)
        ->not->toThrow(ArrayKeyAlreadyExistsException::class)
        ->toHaveCount(2);
});

it('converts a simple one-level array to dot notation', function () {
    $original = ['key' => 'value'];
    $expected = ['key' => 'value'];

    expect(Arrays::toDotNotation($original))->toBe($expected);
});

it('converts a multi-level array to dot notation', function () {
    $original = ['foo' => ['bar' => 'baz']];
    $expected = ['foo.bar' => 'baz', 'foo' => ['bar' => 'baz']];

    expect(Arrays::toDotNotation($original))->toBe($expected);
});

it('handles an empty array when using dot notation', function () {
    $original = [];
    $expected = [];

    expect(Arrays::toDotNotation($original))->toBe($expected);
});

it('converts array to dot notation with simple mode set to true', function () {
    $original = ['foo' => ['bar' => 'baz']];
    $expected = ['foo.bar' => 'baz'];

    expect(Arrays::toDotNotation($original, true))->toBe($expected);
});

it('converts array to dot notation with simple mode set to false', function () {
    $original = ['foo' => ['bar' => ['baz' => 'qux']]];
    $expected = [
        'foo.bar.baz' => 'qux',
        'foo.bar' => ['baz' => 'qux'],
        'foo' => ['bar' => ['baz' => 'qux']]
    ];

    expect(Arrays::toDotNotation($original, false))->toBe($expected);
});

it('handles arrays with non-string keys', function () {
    $original = [0 => ['foo' => 'bar']];
    $expected = ['0.foo' => 'bar', '0' => ['foo' => 'bar']];

    expect(Arrays::toDotNotation($original))->toBe($expected);
});
