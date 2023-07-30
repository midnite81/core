<?php

declare(strict_types=1);

use Midnite81\Core\Carbon\Carbon;

it('correctly formats dayDisplay', function () {
    $carbon = new Carbon('2023-07-28 12:34:56');
    $formatted = $carbon->dayDisplay();

    expect($formatted)->toBe('Friday, 28th July');
});

it('correctly formats dayDisplayWithYear', function () {
    $carbon = new Carbon('2023-07-28 12:34:56');
    $formatted = $carbon->dayDisplayWithYear();

    expect($formatted)->toBe('Friday, 28th July, 2023');
});

it('correctly sets timezone to London', function () {
    $carbon = new Carbon('2023-07-28 12:34:56');
    $carbonLondon = $carbon->london();

    expect($carbonLondon)
        ->toBeInstanceOf(Carbon::class)
        ->and($carbonLondon->tzName)->toBe('Europe/London');
});
