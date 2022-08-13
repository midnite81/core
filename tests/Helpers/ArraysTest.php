<?php

use Midnite81\Core\Helpers\Arrays;

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
