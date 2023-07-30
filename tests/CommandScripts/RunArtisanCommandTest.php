<?php

use Midnite81\Core\CommandScripts\RunArtisanCommand;

it('can announce itself with custom message', function () {
    $commandSignature = 'example:command';
    $message = 'Custom message for the command';

    $command = new RunArtisanCommand($commandSignature);
    $command->withMessage($message);

    expect($command->shouldAnnounce)
        ->toBeTrue()
        ->and($command->message)->toBe($message);
});

it('can announce itself', function () {
    $commandSignature = 'example:command';

    $command = new RunArtisanCommand($commandSignature);
    $command->shouldAnnounce();

    expect($command->shouldAnnounce)->toBeTrue();
});

it('can execute without announcement', function () {
    $commandSignature = 'example:command';

    $command = new RunArtisanCommand($commandSignature);
    $command->shouldNotAnnounce();

    expect($command->shouldAnnounce)->toBeFalse();
});

it('can serialize and unserialize the object', function () {
    $commandSignature = 'example:command';
    $message = 'Custom message for the command';

    $command = new RunArtisanCommand($commandSignature);
    $command->withMessage($message);

    $serialized = serialize($command);
    $unserialisedCommand = unserialize($serialized);

    expect($unserialisedCommand)
        ->toBeInstanceOf(RunArtisanCommand::class)
        ->and($unserialisedCommand->commandSignature)->toBe($commandSignature)
        ->and($unserialisedCommand->message)->toBe($message)
        ->and($unserialisedCommand->shouldAnnounce)->toBeTrue();
});

it('can set state of the object', function () {
    $commandSignature = 'example:command';
    $message = 'Custom message for the command';

    $command = new RunArtisanCommand($commandSignature);
    $command->withMessage($message);

    $commandState = var_export($command, true);
    eval("\$unserialisedCommand = $commandState;");

    expect($unserialisedCommand)
        ->toBeInstanceOf(RunArtisanCommand::class)
        ->and($unserialisedCommand->commandSignature)->toBe($commandSignature)
        ->and($unserialisedCommand->message)->toBe($message)
        ->and($unserialisedCommand->shouldAnnounce)->toBeTrue();
});
