<?php

declare(strict_types=1);

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('matches exact single IP', function () {
    $ip = '192.168.1.1';
    $domain = new \Midnite81\Core\Network\IpMatcher($ip);

    expect($domain->match($ip))->toBeTrue()
        ->and($domain->match('192.168.1.2'))->toBeFalse();
});

it('matches multiple IPs, including wildcards', function () {
    $domain = new \Midnite81\Core\Network\IpMatcher(['192.168.1.100', '10.0.0.1']);

    expect($domain->match('192.168.1.*'))->toBeTrue()
        ->and($domain->match('10.0.0.1'))->toBeTrue()
        ->and($domain->match('10.0.0.2'))->toBeFalse();
});

it('matches using matchAgainstList method', function () {
    $domain = new \Midnite81\Core\Network\IpMatcher('192.168.1.10');
    $ipList = ['192.168.1.*', '10.0.0.1'];

    expect($domain->matchAgainstList($ipList))->toBeTrue()
        ->and($domain->matchAgainstList(['10.0.0.2', '10.0.0.3']))->toBeFalse();
});

it('creates instance with of method', function () {
    $ip = '192.168.1.1';
    $domain = \Midnite81\Core\Network\IpMatcher::of($ip);

    expect($domain->match($ip))->toBeTrue();
});

it('creates instance with fromRequestIp method', function () {
    $mockIp = '192.168.1.1';
    $mockRequest = Mockery::mock(\Illuminate\Http\Request::class);
    $mockRequest->shouldReceive('ip')->once()->andReturn($mockIp);
    $mockRequest->shouldReceive('setUserResolver')->once();
    $this->app->instance('request', $mockRequest);

    $domain = \Midnite81\Core\Network\IpMatcher::fromRequestIp();

    expect($domain->match($mockIp))->toBeTrue();
});

it('creates instance with fromRequestIps method', function () {
    $mockIp = '192.168.1.1';
    $mockRequest = Mockery::mock(\Illuminate\Http\Request::class);
    $mockRequest->shouldReceive('ips')->once()->andReturn($mockIp);
    $mockRequest->shouldReceive('setUserResolver')->once();
    $this->app->instance('request', $mockRequest);

    $domain = \Midnite81\Core\Network\IpMatcher::fromRequestIps();

    expect($domain->match($mockIp))->toBeTrue();
});

it('handles wildcard at the beginning', function () {
    $domain = new \Midnite81\Core\Network\IpMatcher('127.0.0.1');
    expect($domain->match('*.*.*.*'))->toBeTrue();

    $domain = new \Midnite81\Core\Network\IpMatcher('192.168.244.232');
    expect($domain->match('*.*.*.*'))->toBeTrue();
});

it('handles wildcard in the middle', function () {
    $domain = new \Midnite81\Core\Network\IpMatcher('192.168.1.1');
    expect($domain->match('192.*.1.1'))->toBeTrue();

    $domain = new \Midnite81\Core\Network\IpMatcher('192.0.1.1');
    expect($domain->match('192.*.1.1'))->toBeTrue();

    $domain = new \Midnite81\Core\Network\IpMatcher('192.168.2.1');
    expect($domain->match('192.*.1.1'))->toBeFalse();
});
