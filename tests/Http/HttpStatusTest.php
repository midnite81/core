<?php

declare(strict_types=1);

use Midnite81\Core\Http\HttpStatus;

it('can parse a 404 error code', function () {
    $sut = HttpStatus::getStatusDescription(HttpStatus::HTTP_NOT_FOUND);

    expect($sut)->toBe('Not Found');
});

it('can parse a 403 error code', function () {
    $sut = HttpStatus::getStatusDescription(HttpStatus::HTTP_FORBIDDEN);

    expect($sut)->toBe('Forbidden');
});
