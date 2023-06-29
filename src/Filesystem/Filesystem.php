<?php

declare(strict_types=1);

namespace Midnite81\Core\Filesystem;

use Illuminate\Filesystem\Filesystem as LaravelFilesystem;
use InvalidArgumentException;
use Midnite81\Core\Exceptions\Filesystem\CouldNotChangeGroupException;
use Midnite81\Core\Exceptions\Filesystem\CouldNotChangeOwnerException;
use Midnite81\Core\Exceptions\Filesystem\CouldNotChangePermissionsException;
use Midnite81\Core\Exceptions\General\FileNotFoundException;

class Filesystem
{
    public function __construct(protected LaravelFilesystem $filesystem)
    {
    }

    public static function make(): Filesystem
    {
        return app(Filesystem::class);
    }

    /**
     * Change the user and group of a file
     *
     * @param string $file
     * @param string|null $user
     * @param string|null $group
     * @return bool
     *
     * @throws CouldNotChangeGroupException
     * @throws CouldNotChangeOwnerException
     * @throws FileNotFoundException
     * @throws InvalidArgumentException
     */
    public function chown(string $file, ?string $user = null, ?string $group = null): bool
    {
        if ($this->filesystem->missing($file)) {
            throw new FileNotFoundException("The file {$file} does not exist");
        }

        if (empty($user) && empty($group)) {
            throw new InvalidArgumentException('You must provide a user or group');
        }

        if (!empty($user) && !chown($file, $user)) {
            throw new CouldNotChangeOwnerException("Could not change owner of {$file} to {$user}");
        }

        if (!empty($group) && !chgrp($file, $group)) {
            throw new CouldNotChangeGroupException("Could not change group of {$file} to {$group}");
        }

        return true;
    }

    /**
     * Try chown, but catch any exceptions and return false
     *
     * @param string $file
     * @param string $user
     * @param string $owner
     * @return bool
     */
    public function tryChown(string $file, string $user, string $owner): bool
    {
        try {
            return $this->chown($file, $user, $owner);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Change file permissions
     *
     * @param string $file
     * @param int|null $permissions
     * @return bool
     *
     * @throws CouldNotChangePermissionsException
     */
    public function chmod(string $file, ?int $permissions): bool
    {
        $action = $this->filesystem->chmod($file, $permissions);

        if ($action === false) {
            throw new CouldNotChangePermissionsException("Could not change permissions on {$file}");
        }

        return $action;
    }

    /**
     * Try chmod, but catch any exceptions and return false
     *
     * @param string $file
     * @param int|null $permissions
     * @return bool
     */
    public function tryChmod(string $file, ?int $permissions): bool
    {
        try {
            return $this->chmod($file, $permissions);
        } catch (CouldNotChangePermissionsException $e) {
            return false;
        }
    }
}
