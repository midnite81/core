<?php

declare(strict_types=1);

namespace Midnite81\Core\Contracts\Network\Libraries;

use Illuminate\Support\Collection;

interface LibraryInterface
{
    /**
     * Retrieves a dictionary of user agents (value) and their corresponding names (key).
     *
     * @return Collection<string, string> A collection of key-value pairs where the key is the user agent name
     *                                    and the value is the user agent string.
     */
    public function dictionary(): Collection;
}
