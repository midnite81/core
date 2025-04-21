<?php

declare(strict_types=1);

it('implements Library interface and dictionary is a collection', function () {
    expect($class = new \Midnite81\Core\Network\Libraries\Previewers)
        ->toBeInstanceOf(\Midnite81\Core\Contracts\Network\Libraries\LibraryInterface::class)
        ->and($class->dictionary())->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($class = new \Midnite81\Core\Network\Libraries\SearchEngines)
        ->toBeInstanceOf(\Midnite81\Core\Contracts\Network\Libraries\LibraryInterface::class)
        ->and($class->dictionary())->toBeInstanceOf(\Illuminate\Support\Collection::class);

});
