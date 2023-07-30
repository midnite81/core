<?php

declare(strict_types=1);

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('returns provides', function () {
    $sut = (new \Midnite81\Core\CoreServiceProvider($this->app))->provides();

    expect($sut)->toBeArray()->toContain('m81-uuid');
});
