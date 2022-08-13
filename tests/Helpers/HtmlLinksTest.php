<?php

use Midnite81\Core\Helpers\HtmlLinks;

uses(\Midnite81\Core\Tests\TestCase::class);

it('adds target blank to external links', function () {
    $html = '<h1>Hello World <a href="simon.html">Simon!</a>. Have you seen <a href="https://google.com">Google</a> today?</h1>';
    $htmlRevised = '<h1>Hello World <a href="simon.html">Simon!</a>. Have you seen <a target="_blank" rel="noopener noreferrer" href="https://google.com">Google</a> today?</h1>';

    $request = \Illuminate\Http\Request::create('https://midnite.uk/test');

    $sut = HtmlLinks::targetBlank($html, $request);

    expect($sut)
        ->toBeString()
        ->toBe($htmlRevised);
});

it('adds target blank to external colon slash slash links', function () {
    $html = '<h1>Hello World <a href="simon.html">Simon!</a>. Have you seen <a href="://google.com">Google</a> today?</h1>';
    $htmlRevised = '<h1>Hello World <a href="simon.html">Simon!</a>. Have you seen <a target="_blank" rel="noopener noreferrer" href="://google.com">Google</a> today?</h1>';

    $request = \Illuminate\Http\Request::create('https://midnite.uk/test');

    $sut = HtmlLinks::targetBlank($html, $request);

    expect($sut)
        ->toBeString()
        ->toBe($htmlRevised);
});

it('should not convert internal links', function () {
    $html = '<h1>Have you seen <a href="://midnite.uk/me">me</a> today? What about <a href="https://google.com">Google</a>?</h1>';
    $htmlRevised = '<h1>Have you seen <a href="://midnite.uk/me">me</a> today? What about <a target="_blank" rel="noopener noreferrer" href="https://google.com">Google</a>?</h1>';

    $request = \Illuminate\Http\Request::create('https://midnite.uk/test');

    $sut = HtmlLinks::targetBlank($html, $request);

    expect($sut)
        ->toBeString()
        ->toBe($htmlRevised);
});
