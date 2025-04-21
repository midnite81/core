<?php

declare(strict_types=1);

uses(\Midnite81\Core\Tests\CoreTestCase::class);

use Midnite81\Core\Commands\Development\FireScriptsCommand;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Tests\CommandScripts\Fixtures\CommandScript;
use Mockery\MockInterface;

it('should announce before running if shouldAnnounce is true', function () {
    /** @var CommandScript|MockInterface $commandScript */
    $commandScript = new CommandScript;
    $commandScript->shouldAnnounce();

    expect($commandScript->shouldAnnounce)->toBe(true);
});

it('should not announce before running if shouldAnnounce is false', function () {
    /** @var CommandScript|MockInterface $commandScript */
    $commandScript = new CommandScript;
    $commandScript->shouldNotAnnounce();

    expect($commandScript->shouldAnnounce)->toBe(false);
});

it('should provide message', function () {
    /** @var CommandScript|MockInterface $commandScript */
    $commandScript = new CommandScript;
    $commandScript->withMessage('Test Message');

    expect($commandScript->message)->toBe('Test Message');
});

it('should execute the handle method', function () {
    $execute = Mockery::mock(ExecuteInterface::class);
    $command = new FireScriptsCommand($execute);

    $commandScript = new CommandScript;
    $result = $commandScript->handle($command, $execute);

    expect($result)->toBe(0);
});

it('should serialize and unserialize correctly', function () {
    $commandScript = new CommandScript;
    $serialized = serialize($commandScript);
    $unserialized = unserialize($serialized);

    expect($unserialized)->toBeInstanceOf(CommandScript::class);
    expect($unserialized->shouldAnnounce)->toBe($commandScript->shouldAnnounce);
    expect($unserialized->message)->toBe($commandScript->message);
});

it('should set state correctly', function () {
    $commandScript = CommandScript::__set_state([
        'shouldAnnounce' => false,
        'message' => 'Test Message',
    ]);

    expect($commandScript)->toBeInstanceOf(CommandScript::class);
    expect($commandScript->shouldAnnounce)->toBe(false);
    expect($commandScript->message)->toBe('Test Message');
});
