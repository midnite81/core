<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\uuid;

uses(\Midnite81\Core\Tests\TestCase::class);

it('can generate a uuid', function () {
    $uuid = uuid();

    expect($uuid)->not()->toBeEmpty()
                 ->and($uuid)->toBeString()
                 ->and($uuid)->toHaveLength(36)
                ->and((bool) preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid))->toBeTrue();
});
