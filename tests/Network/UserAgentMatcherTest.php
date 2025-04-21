<?php

declare(strict_types=1);

uses(\Midnite81\Core\Tests\CoreTestCase::class);

use Midnite81\Core\Network\UserAgentMatcher;
use Midnite81\Core\Tests\Network\Fixtures\TestDictionary;

it('returns an error if no dictionaries are passed', function () {
    $ua = new UserAgentMatcher;
    expect(fn () => $ua->match())->toThrow(InvalidArgumentException::class, 'No dictionaries have been set');
});

it('returns an error if no dictionaries are not instance of Library Interface', function () {
    expect(fn () => (new UserAgentMatcher(null, ['test']))->match())
        ->toThrow(InvalidArgumentException::class, 'The class test could not be found')
        ->and(fn () => (new UserAgentMatcher(null, [new stdClass]))->match())
        ->toThrow(InvalidArgumentException::class, 'The class stdClass must implement Midnite81\Core\Contracts\Network\Libraries\LibraryInterface')
        ->and(fn () => (new UserAgentMatcher(null, [new UserAgentMatcher]))->match())
        ->toThrow(InvalidArgumentException::class, 'The class Midnite81\Core\Network\UserAgentMatcher must implement Midnite81\Core\Contracts\Network\Libraries\LibraryInt');
});

it('instantiates the dictionary when passed as a string class', function () {
    $ua = new UserAgentMatcher(userAgent: 'testing ghi', dictionaries: [TestDictionary::class]);
    expect($ua->match())->toBeTrue();
});

it('returns true if the user agent is part of any value in the dictionaries', function () {
    $ua = new UserAgentMatcher(
        'Testing ghi123',
        [new TestDictionary]
    );
    expect($ua->match())->toBeTrue();
});

it('returns true if the user agent matches exactly with a dictionary value', function () {
    $ua = new UserAgentMatcher(
        'ghi',
        [new TestDictionary]
    );
    expect($ua->match(exactMatch: true))->toBeTrue();
});

it('returns false if the user agent does not match exactly with a dictionary value', function () {
    $ua = new UserAgentMatcher(
        'ghi 123',
        [new TestDictionary]
    );
    expect($ua->match(exactMatch: true))->toBeFalse();
});

it('returns false if the user agent does not match any value in the dictionaries', function () {
    $ua = new UserAgentMatcher(
        'Testing 123',
        [new TestDictionary]
    );
    expect($ua->match())->toBeFalse();
});

it('returns true if the user agent matches a key in the dictionary', function () {
    $ua = new UserAgentMatcher(
        'abc123',
        [new TestDictionary]
    );
    expect($ua->match(matchKey: true))->toBeTrue();
});

it('returns true if the user agent matches a key in the dictionary if exact match', function () {
    $ua = new UserAgentMatcher(
        'abc',
        [new TestDictionary]
    );
    expect($ua->match(exactMatch: true, matchKey: true))->toBeTrue();
});

it('returns false if the user agent does not match a key in the dictionary', function () {
    $ua = new UserAgentMatcher(
        'abc 123',
        [new TestDictionary]
    );
    expect($ua->match(exactMatch: true, matchKey: true))->toBeFalse();
});

it('returns true when given a user agent that matches a dictionary value', function () {
    $ua = new UserAgentMatcher;
    $ua->setUserAgent('ghi123');
    $ua->setDictionaries([new TestDictionary]);
    expect($ua->match())->toBeTrue();
});

it('returns true when no match is found', function () {
    $ua = new UserAgentMatcher(
        'xyz',
        [new TestDictionary]
    );
    expect($ua->noMatch())->toBeTrue();
});

it('returns false when a match is found', function () {
    $ua = new UserAgentMatcher(
        'ghi',
        [new TestDictionary]
    );
    expect($ua->noMatch())->toBeFalse();
});

it('returns false when an exact match is found', function () {
    $ua = new UserAgentMatcher(
        'GHI',
        [new TestDictionary]
    );
    expect($ua->noMatch(exactMatch: true))->toBeFalse();
});

it('returns true when matched case sensitively', function () {
    $ua = new UserAgentMatcher(
        'GHI',
        [new TestDictionary]
    );

    expect($ua->match(caseSensitive: true))->toBeTrue();
});

it('returns false when no match is found case sensitively', function () {
    $ua = new UserAgentMatcher(
        'ghi',
        [new TestDictionary]
    );

    expect($ua->match(caseSensitive: true))->toBeFalse();
});

it('returns false when no match on key is found case sensitively', function () {
    $ua = new UserAgentMatcher(
        'abc',
        [new TestDictionary]
    );

    expect($ua->match(caseSensitive: true, matchKey: true))->toBeFalse();
});
