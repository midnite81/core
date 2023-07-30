<?php

use Midnite81\Core\Exceptions\DirectionException;

it('throws the correct exception with the correct message', function () {
    $invalidDirection = 'INVALID_DIRECTION';

    try {
        throw new DirectionException($invalidDirection);
    } catch (DirectionException $exception) {
        expect($exception->getMessage())->toBe(
            "The direction specified [$invalidDirection] is not valid. ASC or DESC should be specified"
        );
    }
});

it('throws the correct exception with the correct message when using ASC', function () {
    $direction = 'ASC';

    try {
        throw new DirectionException($direction);
    } catch (DirectionException $exception) {
        expect($exception->getMessage())->toBe(
            "The direction specified [$direction] is not valid. ASC or DESC should be specified"
        );
    }
});

it('throws the correct exception with the correct message when using DESC', function () {
    $direction = 'DESC';

    try {
        throw new DirectionException($direction);
    } catch (DirectionException $exception) {
        expect($exception->getMessage())->toBe(
            "The direction specified [$direction] is not valid. ASC or DESC should be specified"
        );
    }
});
