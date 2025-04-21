<?php

use Illuminate\Console\Command;
use Midnite81\Core\Commands\Development\FireScriptsCommand;
use Midnite81\Core\CommandScripts\SwitchBranches;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Exceptions\Commands\Development\CommandFailedException;

it('switches to an existing branch', function () {
    $branchName = 'existing-branch';

    $command = Mockery::mock(FireScriptsCommand::class);
    $execute = Mockery::mock(ExecuteInterface::class);

    $command->shouldReceive('arguments')->andReturn(['args' => [$branchName]]);
    $command->shouldReceive('getExtendedOption')->with('new')->andReturn(false);
    $command->shouldReceive('info')->times(3);

    $execute->shouldReceive('passthru')->with("git checkout {$branchName}")->andReturn(0);

    $switchBranches = new SwitchBranches;
    $result = $switchBranches->handle($command, $execute);

    expect($result)->toBe(Command::SUCCESS);
});

it('creates and switches to a new branch', function () {
    $branchName = 'new-branch';

    $command = Mockery::mock(FireScriptsCommand::class);
    $execute = Mockery::mock(ExecuteInterface::class);

    $command->shouldReceive('arguments')->andReturn(['args' => [$branchName]]);
    $command->shouldReceive('getExtendedOption')->with('new')->andReturn(true);
    $command->shouldReceive('info')->times(3);

    $execute->shouldReceive('passthru')->with("git checkout -b {$branchName}")->andReturn(0);

    $switchBranches = new SwitchBranches;
    $result = $switchBranches->handle($command, $execute);

    expect($result)->toBe(Command::SUCCESS);
});

it('throws an exception on command failure when abort_on_failure is true', function () {
    $branchName = 'existing-branch';

    $command = Mockery::mock(FireScriptsCommand::class);
    $execute = Mockery::mock(ExecuteInterface::class);

    $command->shouldReceive('arguments')->andReturn(['args' => [$branchName]]);
    $command->shouldReceive('getExtendedOption')->with('new')->andReturn(false);
    $command->shouldReceive('info')->times(3);
    $command->shouldReceive('abortOnFailure')->andReturn(true);

    $execute->shouldReceive('passthru')->with("git checkout {$branchName}")->andReturn(1);

    $switchBranches = new SwitchBranches;

    expect(function () use ($switchBranches, $command, $execute) {
        $switchBranches->handle($command, $execute);
    })->toThrow(CommandFailedException::class);
});

it('returns null when no branch name is given', function () {
    $command = Mockery::mock(FireScriptsCommand::class);
    $execute = Mockery::mock(ExecuteInterface::class);

    $command->shouldReceive('arguments')->andReturn(['args' => []]);

    $switchBranches = new SwitchBranches;
    $result = $switchBranches->handle($command, $execute);

    expect($result)->toBe(Command::SUCCESS);
});
