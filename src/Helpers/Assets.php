<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Illuminate\Filesystem\Filesystem;

class Assets
{
    public function __construct(protected Filesystem $filesystem)
    {
    }

    /**
     * Generates a versioned asset URL.
     *
     * This method appends the last modified timestamp of the file to the asset URL to ensure cache busting.
     * If the file does not exist, the original asset URL is returned.
     *
     * @param string $filePath The relative path to the asset file.
     * @return string The versioned asset URL.
     */
    public function versionedAsset(string $filePath): string
    {
        if (file_exists(public_path($filePath))) {
            return asset($filePath) . '?v=' . filemtime(public_path($filePath));
        }

        return asset($filePath);
    }
}
