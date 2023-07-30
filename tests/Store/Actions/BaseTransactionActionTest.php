<?php

declare(strict_types=1);

uses(\Midnite81\Core\Tests\CoreTestCase::class);

use Illuminate\Database\Connection;
use Midnite81\Core\Store\Actions\BaseTransactionAction;
use Mockery\MockInterface;

it('can begin a transaction', function () {
    $connectionMock = \Mockery::mock(Connection::class, function (MockInterface $mock) {
        $mock->shouldReceive('beginTransaction')->once();
    });

    $transactionAction = new class($connectionMock) extends BaseTransactionAction {
        public function getConnection(): Connection
        {
            return $this->connection;
        }
    };

    $transactionAction->beginTransaction();

    $connectionMock->shouldHaveReceived('beginTransaction')->once();
});

it('can commit a transaction', function () {
    $connectionMock = \Mockery::mock(Connection::class, function (MockInterface $mock) {
        $mock->shouldReceive('commit')->once();
    });

    $transactionAction = new class($connectionMock) extends BaseTransactionAction {
        public function getConnection(): Connection
        {
            return $this->connection;
        }
    };

    $transactionAction->commitTransaction();

    $connectionMock->shouldHaveReceived('commit')->once();
});

it('can rollback a transaction', function () {
    $connectionMock = \Mockery::mock(Connection::class, function (MockInterface $mock) {
        $mock->shouldReceive('rollBack')->once();
    });

    $transactionAction = new class($connectionMock) extends BaseTransactionAction {
        public function getConnection(): Connection
        {
            return $this->connection;
        }
    };

    $transactionAction->rollbackTransaction();

    $connectionMock->shouldHaveReceived('rollBack')->once();
});

it('can execute a transaction closure', function () {
    $expectedResult = 'Transaction Result';
    $callback = function () use ($expectedResult) {
        return $expectedResult;
    };

    $connectionMock = \Mockery::mock(Connection::class, function (MockInterface $mock) use ($expectedResult, $callback) {
        $mock->shouldReceive('transaction')
             ->with($callback, 1)
             ->andReturn($expectedResult)
             ->once();
    });

    $transactionAction = new class($connectionMock) extends BaseTransactionAction {
        public function getConnection(): Connection
        {
            return $this->connection;
        }
    };

    $result = $transactionAction->try($callback);

    $connectionMock->shouldHaveReceived('transaction')->once();
    expect($result)->toBe($expectedResult);
});
