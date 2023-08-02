<?php

declare(strict_types=1);

use Midnite81\Core\Exceptions\General\FileNotFoundException;
use Midnite81\Core\Filesystem\Filesystem;

it('throws FileNotFoundException if file does not exist', function () {
    $file = 'non_existent_file.txt';
    $filesystem = Mockery::mock(\Illuminate\Filesystem\Filesystem::class);
    $filesystem->shouldReceive('missing')->once()->with($file)->andReturn(true);

    $filesystemWrapper = new Filesystem($filesystem);

    expect(fn () => $filesystemWrapper->chown($file))
        ->toThrow(FileNotFoundException::class, "The file {$file} does not exist");
});

it('throws FileNotFoundException if user or group not passed', function () {
    $file = 'non_existent_file.txt';
    $filesystem = Mockery::mock(\Illuminate\Filesystem\Filesystem::class);
    $filesystem->shouldReceive('missing')->once()->with($file)->andReturn(false);

    $filesystemWrapper = new Filesystem($filesystem);

    expect(fn () => $filesystemWrapper->chown($file))
        ->toThrow(InvalidArgumentException::class, 'You must provide a user or group');
});

it('throws FileNotFoundException if user or group not passed using tryChown', function () {
    $file = 'non_existent_file.txt';
    $filesystem = Mockery::mock(\Illuminate\Filesystem\Filesystem::class);
    $filesystem->shouldReceive('missing')->once()->with($file)->andReturn(false);

    $filesystemWrapper = new Filesystem($filesystem);

    expect($filesystemWrapper->tryChown($file))
        ->toBeFalse();
});

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

it('can change the permission on the file to 777 using try', function () {
    $filename = __DIR__ . '/test.txt';
    $file = fopen($filename, 'w');
    fwrite($file, 'This is a test file.');
    fclose($file);
    chmod($filename, 0644);

    \Midnite81\Core\Filesystem\Filesystem::make()->tryChmod($filename, 0777);

    expect(decoct(fileperms($filename) & 0777))->toBe('777');

    unlink($filename);
});

it('can change the permission on the file to 600 using try', function () {
    $filename = __DIR__ . '/test.txt';
    $file = fopen($filename, 'w');
    fwrite($file, 'This is a test file.');
    fclose($file);
    chmod($filename, 0644);

    \Midnite81\Core\Filesystem\Filesystem::make()->tryChmod($filename, 0600);

    expect(decoct(fileperms($filename) & 0777))->toBe('600');

    unlink($filename);
});
