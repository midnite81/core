<?php

declare(strict_types=1);

it('attempts successfully', function () {
    $sut = \Midnite81\Core\Helpers\Attempt::attempt(function () {
        return 'Hello World';
    });

    expect($sut)->toBeInstanceOf(\Midnite81\Core\Entities\AttemptEntity::class)
        ->and($sut->successful)->toBeTrue()
        ->and($sut->result)->toBe('Hello World')
        ->and($sut->hasErrored)->toBeFalse()
        ->and($sut->throwable)->toBeNull();
});

it('attempts fails gracefully', function () {
    $sut = \Midnite81\Core\Helpers\Attempt::attempt(function () {
        /** @noinspection PhpUndefinedNamespaceInspection */
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        return \Class\That\Doesnt\Exist::shouldFail();
    });

    expect($sut)->toBeInstanceOf(\Midnite81\Core\Entities\AttemptEntity::class)
        ->and($sut->successful)->toBeFalse()
        ->and($sut->result)->toBeNull()
        ->and($sut->hasErrored)->toBeTrue()
        ->and($sut->throwable)->toBeInstanceOf(Throwable::class);
});
