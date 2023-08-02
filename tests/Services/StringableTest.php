<?php

declare(strict_types=1);

it('can return __toString from a class', function () {
    $class = new class()
    {
        public function __toString()
        {
            return 'Hello';
        }
    };

    $sut = (new \Midnite81\Core\Services\Stringable())->toString($class);

    expect($sut)->toBe('Hello');
});
