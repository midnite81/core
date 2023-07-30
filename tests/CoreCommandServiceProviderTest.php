<?php

use Illuminate\Contracts\Foundation\Application;
use Midnite81\Core\CoreCommandServiceProvider;

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('registers commands when running in console', function () {
    $applicationMock = \Mockery::mock(Application::class);
    $applicationMock->shouldReceive('runningInConsole')->andReturnTrue();
    $applicationMock->shouldReceive('make')->with(Midnite81\Core\Commands\Database\BackupDatabase::class)->once();
    $applicationMock->shouldReceive('make')->with(Midnite81\Core\Commands\Development\FireScriptsCommand::class)->once();
    $applicationMock->shouldReceive('make')->with(Midnite81\Core\Commands\Development\QuickFireScriptCommand::class)->once();
    $applicationMock->shouldReceive('make')->with(Midnite81\Core\Commands\Environments\ChangeEnvironmentVariable::class)->once();
    $applicationMock->shouldReceive('make')->with(Midnite81\Core\Commands\Environments\CreateBlankCopyOfEnvironmentFile::class)->once();
    $applicationMock->shouldReceive('make')->with(Midnite81\Core\Commands\Environments\GetEnvironmentVariable::class)->once();

    $serviceProvider = new CoreCommandServiceProvider($applicationMock);

    $serviceProvider->boot();
});
