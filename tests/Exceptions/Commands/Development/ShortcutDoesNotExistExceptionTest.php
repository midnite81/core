<?php

use Midnite81\Core\Exceptions\Commands\Development\ShortcutDoesNotExistException;

it('throws the correct exception with the correct message', function () {
    $shortcutKey = 'CTRL+S';

    try {
        throw new ShortcutDoesNotExistException($shortcutKey);
    } catch (ShortcutDoesNotExistException $exception) {
        expect($exception->getMessage())->toBe(
            "The shortcut key [$shortcutKey] does not exist in the configuration"
        );
    }
});
