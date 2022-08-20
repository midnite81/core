<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Midnite81\Core\Entities\Matches\MatchEntity;
use Midnite81\Core\Helpers\Matches;

it('returns a MatchEntity', function () {
    $sut = Matches::match('/foo/', 'foo');

    expect($sut)
        ->toBeInstanceOf(MatchEntity::class)
        ->and($sut->matched)->toBeTrue()
        ->and($sut->matches)->toBeInstanceOf(Collection::class)
        ->and($sut->matches)->toHaveCount(1);
});

it('gets sub string sections', function () {
    $sut = Matches::match('/id="(.*?)"/', 'id="dave"');

    expect($sut)
        ->toBeInstanceOf(MatchEntity::class)
        ->and($sut->matched)->toBeTrue()
        ->and($sut->matches)->toBeInstanceOf(Collection::class)
        ->and($sut->matches)->toHaveCount(2)
        ->sequence(
            fn ($match) => $match->toBe('id="dave"'),
            fn ($match) => $match->toBe('dave'),
        );
});
