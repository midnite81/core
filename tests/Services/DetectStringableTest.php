<?php

declare(strict_types=1);

use Midnite81\Core\Services\DetectStringable as DS;
use Midnite81\Core\Tests\Services\Fixtures\StringClass;

it('identifies stringables', function () {
    expect(DS::isStringable('string'))
        ->toBeTrue()
        ->and(DS::isStringable(121))->toBeTrue()
        ->and(DS::isStringable(12932.392))->toBeTrue();
});

it('identifies non stringables', function () {
    $entity = new \Midnite81\Core\Tests\Entities\TestHelpers\TestEntity;

    expect(DS::isNotStringable(['name' => 'dave']))
        ->toBeTrue()
        ->and(DS::isNotStringable(new stdClass))->toBeTrue()
        ->and(DS::isNotStringable($entity))->toBeTrue();
});

it('identifies classes with toString as stringable', function () {
    expect(DS::isStringable(new StringClass))
        ->toBeTrue();
});
