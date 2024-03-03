<?php

declare(strict_types=1);

namespace Midnite81\Core\Network\Libraries;

use Illuminate\Support\Collection;
use Midnite81\Core\Contracts\Network\Libraries\LibraryInterface;

class UnknownUserAgent implements LibraryInterface
{
    /**
     * {@inheritDoc}
     */
    public function dictionary(): Collection
    {
        return collect([
            'UnknownUserAgent' => 'UnknownUserAgent',
            '' => '',
        ]);
    }
}
