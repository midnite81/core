<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Midnite81\Core\Http\Middleware\LogControllerAndMethod;
use Midnite81\Core\Tests\CoreTestCase;

uses(CoreTestCase::class);

it('asserts the middleware executes', function () {

    $request = Request::create('/test', 'GET');

    $closure = function ($request) {
        return 'Closure executed';
    };

    $middleware = new LogControllerAndMethod();

    $response = $middleware->handle($request, $closure);

    expect($response)->toBe('Closure executed');
});

it('hits the logs', function () {
    Config::set('core-middleware.allowable-environments', ['testing']);

    $request = Request::create('/test', 'GET');

    $closure = function ($request) {
        return 'Closure executed';
    };

    $route = Mockery::mock(\Illuminate\Routing\Route::class);
    $route->shouldReceive('getActionName')
        ->once()
        ->andReturn('TestController@testMethod');
    $request->setRouteResolver(function () use ($route) {
        return $route;
    });

    $rayMock = Mockery::mock(\Spatie\LaravelRay\Ray::class);

    $rayMock->shouldReceive('send')
        ->once()
        ->with(['Controller' => 'TestController', 'Method' => 'testMethod']);

    app()->instance(Spatie\LaravelRay\Ray::class, $rayMock);

    $middleware = new LogControllerAndMethod();
    $response = $middleware->handle($request, $closure);

    Mockery::close();

    expect($response)->toBe('Closure executed');
});

it('hits the logs with local', function () {
    Config::set('core-middleware.allowable-environments', []);

    $request = Request::create('/test', 'GET');

    $closure = function ($request) {
        return 'Closure executed';
    };

    $route = Mockery::mock(\Illuminate\Routing\Route::class);
    $route->shouldReceive('getActionName')
        ->never()
        ->andReturn('TestController@testMethod');
    $request->setRouteResolver(function () use ($route) {
        return $route;
    });

    $rayMock = Mockery::mock(\Spatie\LaravelRay\Ray::class);

    $rayMock->shouldReceive('send')
        ->never()
        ->with(['Controller' => 'TestController', 'Method' => 'testMethod']);

    app()->instance(Spatie\LaravelRay\Ray::class, $rayMock);

    $middleware = new LogControllerAndMethod();
    $response = $middleware->handle($request, $closure);

    Mockery::close();

    expect($response)->toBe('Closure executed');
});
