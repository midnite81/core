<?php

use Midnite81\Core\Helpers\UserAgent;

it('asserts it\'s facebook', function () {
    $userAgent = 'facebookexternalhit/1.0';
    expect(UserAgent::isFacebook($userAgent))
        ->toBeBool()
        ->toBeTrue();
});

it('asserts it\'s not facebook', function () {
    $userAgent = 'facebook does its own thing';
    expect(UserAgent::isFacebook($userAgent))
        ->toBeBool()
        ->toBeFalse();
});

it('asserts it\'s twitter', function () {
    $userAgent = 'Twitterbot/1.0';
    expect(UserAgent::isTwitter($userAgent))
        ->toBeBool()
        ->toBeTrue();
});

it('asserts it\'s not twitter', function () {
    $userAgent = 'twitter does its own thing';
    expect(UserAgent::isTwitter($userAgent))
        ->toBeBool()
        ->toBeFalse();
});

it('asserts it\'s apple imessaage preview', function ($userAgent) {
    expect(UserAgent::isAppleIMessageLinkPreviewer($userAgent))
        ->toBeBool()
        ->toBeTrue();
})->with([
    'AppleWebKit/12 Facebot Twitterbot',
    '12/AppleWebKit Facebot Twitterbot',
    'Facebot Twitterbot/1.2 AppleWebKit/12',
]);

it('asserts it\'s not apple imessage preview', function ($userAgent) {
    expect(UserAgent::isAppleIMessageLinkPreviewer($userAgent))
        ->toBeBool()
        ->toBeFalse();
})->with([
    'WebKit/12',
    '12/WebKit',
    'TwitterBot',
]);
