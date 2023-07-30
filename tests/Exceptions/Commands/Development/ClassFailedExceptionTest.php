<?php

declare(strict_types=1);

use Midnite81\Core\Exceptions\Commands\Development\ClassFailedException;

it('throws the correct exception with the correct message', function () {
    $className = 'MyScriptClass';

    try {
        throw new ClassFailedException($className);
    } catch (ClassFailedException $exception) {
        expect($exception->getMessage())->toBe(
            "The script class [$className] failed. Aborting the run."
        );
    }
});
