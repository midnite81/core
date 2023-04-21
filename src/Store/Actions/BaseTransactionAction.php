<?php

declare(strict_types=1);

namespace Midnite81\Core\Store\Actions;

use Closure;
use Illuminate\Database\Connection;
use Throwable;

abstract class BaseTransactionAction extends BaseAction
{
    /**
     * The database connection class
     */
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Execute a transaction within a closure
     *
     *
     * @throws Throwable
     */
    public function try(Closure $callback, int $attempts = 1): mixed
    {
        return $this->connection->transaction($callback, $attempts);
    }

    /**
     * Start a new database transaction.
     *
     * @throws Throwable
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit the active database transaction.
     *
     * @throws Throwable
     */
    public function commitTransaction()
    {
        $this->connection->commit();
    }

    /**
     * Rollback the active database transaction.
     *
     * @throws Throwable
     */
    public function rollbackTransaction(): void
    {
        $this->connection->rollBack();
    }
}
