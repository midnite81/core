<?php

use Midnite81\Core\Exceptions\Entities\DuplicatePropertyNameException;
use Midnite81\Core\Tests\Entities\TestHelpers\TestIdenticalPropertiesEntity;

it('should throw exception if two of more of the properties have identical names', function () {
    expect(fn () => new TestIdenticalPropertiesEntity())
        ->toThrow(
            DuplicatePropertyNameException::class,
            'The name [identical] was registered more than once on class [Midnite81\Core\Tests\Entities\TestHelpers\TestIdenticalPropertiesEntity]'
        );
});
