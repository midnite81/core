<?php

declare(strict_types=1);

use Midnite81\Core\Eloquent\Schema;

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('correctly renames the database', function () {
    $oldName = 'old_database';
    $newName = 'new_database';

    $dbMock = \Mockery::mock(\Illuminate\Database\Connection::class);
    $dbMock->shouldReceive('statement')
        ->once()
        ->with('CREATE DATABASE IF NOT EXISTS `new_database`')
        ->andReturn(true);
    $dbMock->shouldReceive('statement')
        ->once()
        ->with('DROP DATABASE IF EXISTS `old_database`')
        ->andReturn(true);

    $executeMock = \Mockery::mock(\Midnite81\Core\Services\Execute::class);
    $executeMock->shouldReceive('exec')
        ->once()
        ->andReturn([]);

    $this->instance(\Illuminate\Database\Connection::class, $dbMock);
    $this->instance(\Midnite81\Core\Services\Execute::class, $executeMock);

    $result = Schema::renameDatabase($oldName, $newName);

    expect($result)->toBeTrue();
});

it('correctly renames the database using non-static method', function () {
    $oldName = 'old_database';
    $newName = 'new_database';

    $dbMock = \Mockery::mock(\Illuminate\Database\Connection::class);
    $dbMock->shouldReceive('statement')
        ->once()
        ->with('CREATE DATABASE IF NOT EXISTS `new_database`')
        ->andReturn(true);
    $dbMock->shouldReceive('statement')
        ->once()
        ->with('DROP DATABASE IF EXISTS `old_database`')
        ->andReturn(true);

    $executeMock = \Mockery::mock(\Midnite81\Core\Services\Execute::class);
    $executeMock->shouldReceive('exec')
        ->once()
        ->andReturn([]);

    $this->instance(\Illuminate\Database\Connection::class, $dbMock);
    $this->instance(\Midnite81\Core\Services\Execute::class, $executeMock);

    $schema = new Schema;

    $result = $schema->updateDatabaseName($oldName, $newName);

    expect($result)->toBeTrue();
});
