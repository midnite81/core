<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Network\Fixtures;

class TestDictionary implements \Midnite81\Core\Contracts\Network\Libraries\LibraryInterface
{
    /**
     * {@inheritDoc}
     */
    public function dictionary(): \Illuminate\Support\Collection
    {
        return collect([
            'ABC' => 'GHI',
        ]);
    }
}
