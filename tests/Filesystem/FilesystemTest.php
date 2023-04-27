<?php

declare(strict_types=1);

it('can change the permission on the file to 777', function () {
    $filename = __DIR__ . '/test.txt';
    $file = fopen($filename, 'w');
    fwrite($file, 'This is a test file.');
    fclose($file);
    chmod($filename, 0644);

    \Midnite81\Core\Filesystem\Filesystem::make()->chmod($filename, 0777);

    expect(decoct(fileperms($filename) & 0777))->toBe('777');

    unlink($filename);
});

it('can change the permission on the file to 600', function () {
    $filename = __DIR__ . '/test.txt';
    $file = fopen($filename, 'w');
    fwrite($file, 'This is a test file.');
    fclose($file);
    chmod($filename, 0644);

    \Midnite81\Core\Filesystem\Filesystem::make()->chmod($filename, 0600);

    expect(decoct(fileperms($filename) & 0777))->toBe('600');

    unlink($filename);
});
