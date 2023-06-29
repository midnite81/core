<?php

declare(strict_types=1);

namespace Midnite81\Core\Eloquent;

use Illuminate\Support\Facades\DB;

class Schema
{
    /**
     * Renames a database
     *
     * This requires the user to have the CREATE AND DROP permission on the database
     * as well as access to mysqldump and mysql.
     *
     * Since the ALTER DATABASE command is no longer available to us we are required to
     * create a new table, dump out the data from the old database table and then import
     * it into the new database and then delete the old database.
     *
     * Please be careful when passing $oldName and $newName as they are not sanitised by
     * the mysql command.
     *
     * @param string $oldName Name of the old database
     * @param string $newName Name of the new database
     * @param string $configConnectionName The name of the connection in the config file
     * @return bool
     */
    public static function renameDatabase(string $oldName, string $newName, string $configConnectionName = 'mysql'): bool
    {
        $oldName = self::sanitise($oldName);
        $newName = self::sanitise($newName);

        $backtickOldName = "`{$oldName}`";
        $backtickNewName = "`{$newName}`";

        $create = DB::statement("CREATE DATABASE IF NOT EXISTS $backtickNewName");

        $backupAndRestore = sprintf(
            'mysqldump -h %s -P %d -u %s -p%s %s | mysql -h %s -P %d -u %s -p%s %s',
            config("database.connections.{$configConnectionName}.host"),
            config("database.connections.{$configConnectionName}.port"),
            config("database.connections.{$configConnectionName}.username"),
            config("database.connections.{$configConnectionName}.password"),
            $oldName,
            config("database.connections.{$configConnectionName}.host"),
            config("database.connections.{$configConnectionName}.port"),
            config("database.connections.{$configConnectionName}.username"),
            config("database.connections.{$configConnectionName}.password"),
            $newName
        );

        exec($backupAndRestore);

        $drop = DB::statement("DROP DATABASE IF EXISTS $backtickOldName");

        return $create && $drop;
    }

    /**
     * Non-static version of renameDatabase
     * Useful for testing/mocking
     * Please read the docblock for renameDatabase.
     *
     * @param string $oldName Name of the old database
     * @param string $newName Name of the new database
     * @param string $configConnectionName The name of the connection in the config file
     */
    public function updateDatabaseName(string $oldName, string $newName, string $configConnectionName = 'mysql'): bool
    {
        return static::renameDatabase($oldName, $newName, $configConnectionName);
    }

    /**
     * Offers basic sanitisation for the passed $value to prevent sql injection
     */
    protected static function sanitise(string $value): string
    {
        // sanitise the string to prevent sql injection
        return str_replace(
            ['\\', "\0", "'", '"', "\x1a"],
            ['\\\\', '\\0', "\\'", '\\"', '\\Z'],
            $value,
        );
    }
}
