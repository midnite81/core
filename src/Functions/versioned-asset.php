<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

/**
 * Generates an asset URL with a versioned query string
 *
 * Example Usage: versioned_asset('css/style.css')
 * Example Return: /css/style.css?v=1234567890
 *
 * @param string $filePath The relative path to the asset file
 * @return string The URL to the versioned asset file
 */
function versioned_asset(string $filePath): string
{
    $assets = app(\Midnite81\Core\Helpers\Assets::class);
    return $assets->versionedAsset($filePath);
}
