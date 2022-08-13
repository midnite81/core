<?php

use Midnite81\Core\Transformers\FileLimiter;

it('can get the first lines of a file', function () {
    $limiter = new FileLimiter(__DIR__ . '/Fixtures/test-file.txt');

    $subjectUnderTest = $limiter->readFirstLines(2)->toString();

    expect($subjectUnderTest)
        ->toBeString()
        ->toBe("line 1\nline 2\n");
});

it('can get the last lines of a file', function () {
    $limiter = new FileLimiter(__DIR__ . '/Fixtures/test-file.txt');

    $subjectUnderTest = $limiter->readLastLines(6)->toString();

    expect($subjectUnderTest)
        ->toBeString()
        ->toBe("line 6\nline 7\nline 8\nline 9\nline 10\n");
});

it('can get the certain lines of a file', function () {
    $limiter = new FileLimiter(__DIR__ . '/Fixtures/test-file.txt');

    $subjectUnderTest = $limiter->readSpecificLines([1, 4, 6])->toString();

    expect($subjectUnderTest)
        ->toBeString()
        ->toBe("line 1\nline 4\nline 6\n");
});

it('it can run multiple queries', function () {
    $limiter = new FileLimiter(__DIR__ . '/Fixtures/test-file.txt');

    $subjectUnderTest = $limiter
        ->readFirstLines(2)
        ->readSpecificLines([5])
        ->readLastLines(2)
        ->toString();

    expect($subjectUnderTest)
        ->toBeString()
        ->toBe("line 1\nline 2\nline 5\nline 10\n");
});

it('it can save the file', function () {
    $limiter = new FileLimiter(__DIR__ . '/Fixtures/test-file.txt');

    $file = $limiter
        ->readFirstLines(2)
        ->readSpecificLines([5])
        ->readLastLines(2)
        ->toFile(__DIR__ . '/Fixtures/save.txt');

    expect($file)
        ->toBeInt()
        ->toBeGreaterThan(0)
        ->and(file_exists(__DIR__ . '/Fixtures/save.txt'))
        ->toBeTrue();

    unlink(__DIR__ . '/Fixtures/save.txt');
});

it('it can return to json', function () {
    $limiter = new FileLimiter(__DIR__ . '/Fixtures/test-file.txt');

    $response = $limiter
        ->readFirstLines(2)
        ->readSpecificLines([5])
        ->readLastLines(2)
        ->toJson();

    expect($response)
        ->toBeString()
        ->toBe('["line 1\n","line 2\n","line 5\n","line 10\n",false]');
});

it('it can return to array', function () {
    $limiter = new FileLimiter(__DIR__ . '/Fixtures/test-file.txt');

    $response = $limiter
        ->readFirstLines(2)
        ->readSpecificLines([5])
        ->readLastLines(2)
        ->toArray();

    expect($response)
        ->toBeArray()
        ->toHaveCount(5)
        ->sequence(
            fn ($item) => $item->toBe("line 1\n"),
            fn ($item) => $item->toBe("line 2\n"),
            fn ($item) => $item->toBe("line 5\n"),
            fn ($item) => $item->toBe("line 10\n"),
            fn ($item) => $item->toBe(false),
        );
});
