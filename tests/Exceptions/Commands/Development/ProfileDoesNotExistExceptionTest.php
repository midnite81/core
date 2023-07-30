<?php

use Midnite81\Core\Exceptions\Commands\Development\ProfileDoesNotExistException;

it('throws the correct exception with the correct message', function () {
    $profileName = 'MyProfile';

    try {
        throw new ProfileDoesNotExistException($profileName);
    } catch (ProfileDoesNotExistException $exception) {
        expect($exception->getMessage())->toBe(
            "The profile [$profileName] does not exist in the configuration"
        );
    }
});
