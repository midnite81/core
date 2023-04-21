<?php

use Midnite81\Core\Tests\Entities\TestHelpers\TestIgnorePropertiesEntity;

it('ignores ignored properties', function () {
    $sut = (new TestIgnorePropertiesEntity())
        ->setId(294)
        ->setName('Dave')
        ->setAge(23);

    expect($sut->getInitialisedProperties())
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item->toBe('Dave'),
            fn ($item) => $item->toBe(23)
        );
});
