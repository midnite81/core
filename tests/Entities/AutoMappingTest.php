<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping\Account;
use Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping\TrimmedClassEntity;
use Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping\TrimmedPropertyEntity;

it('can auto-map', function () {
    $data = [
        'accountName' => 'Test Account',
        'accountNumber' => 123456,
        'upperCaseString' => 'testing',
        'address' => [
            'line1' => '123 Test Street',
            'line2' => 'Test Area',
            'line3' => 'Test Town',
            'town' => 'Test Town',
            'county' => 'Test County',
            'postcode' => 'TE5 7PC',
        ],
        'orders' => [
            [
                'orderNumber' => '123456',
                'orderDate' => '2021-01-01',
            ],
            [
                'orderNumber' => '123457',
                'orderDate' => '2021-01-02',
            ],
        ],
        'accountIdentifier' => '5caea84d-4a93-4eda-99c0-825178b39726',
    ];

    $account = new Account($data);

    expect($account->accountName)->toBe('Test Account')
        ->and($account->accountNumber)->toBe(123456)
        ->and($account->upperCaseString)->toBe('TESTING')
        ->and($account->address->line1)->toBe('123 Test Street')
        ->and($account->address->line2)->toBe('Test Area')
        ->and($account->address->line3)->toBe('Test Town')
        ->and($account->address->town)->toBe('Test Town')
        ->and($account->address->county)->toBe('Test County')
        ->and($account->address->postcode)->toBe('TE5 7PC')
        ->and($account->orders)->toHaveCount(2)
        ->and($account->orders[0]->orderNumber)->toBe('123456')
        ->and($account->orders[0]->orderDate->format('Y-m-d'))->toBe('2021-01-01')
        ->and($account->orders[1]->orderNumber)->toBe('123457')
        ->and($account->orders[1]->orderDate->format('Y-m-d'))->toBe('2021-01-02')
        ->and($account->uniqueIdentifier)->toBe('5caea84d-4a93-4eda-99c0-825178b39726');
});

it('can auto-map stdClass', function () {
    $data = (object) [
        'accountName' => 'Test Account',
        'accountNumber' => 123456,
        'upperCaseString' => 'testing',
        'address' => [
            'line1' => '123 Test Street',
            'line2' => 'Test Area',
            'line3' => 'Test Town',
            'town' => 'Test Town',
            'county' => 'Test County',
            'postcode' => 'TE5 7PC',
        ],
        'orders' => [
            [
                'orderNumber' => '123456',
                'orderDate' => '2021-01-01',
            ],
            [
                'orderNumber' => '123457',
                'orderDate' => '2021-01-02',
            ],
        ],
        'accountIdentifier' => '5caea84d-4a93-4eda-99c0-825178b39726',
    ];

    $account = new Account($data);

    expect($account->accountName)->toBe('Test Account')
        ->and($account->accountNumber)->toBe(123456)
        ->and($account->upperCaseString)->toBe('TESTING')
        ->and($account->address->line1)->toBe('123 Test Street')
        ->and($account->address->line2)->toBe('Test Area')
        ->and($account->address->line3)->toBe('Test Town')
        ->and($account->address->town)->toBe('Test Town')
        ->and($account->address->county)->toBe('Test County')
        ->and($account->address->postcode)->toBe('TE5 7PC')
        ->and($account->orders)->toHaveCount(2)
        ->and($account->orders[0]->orderNumber)->toBe('123456')
        ->and($account->orders[0]->orderDate->format('Y-m-d'))->toBe('2021-01-01')
        ->and($account->orders[1]->orderNumber)->toBe('123457')
        ->and($account->orders[1]->orderDate->format('Y-m-d'))->toBe('2021-01-02')
        ->and($account->uniqueIdentifier)->toBe('5caea84d-4a93-4eda-99c0-825178b39726');
});

it('can trim a mapped property marked with trim string', function () {
    $entity = new TrimmedPropertyEntity([
        'trimmed' => '  keep me tidy  ',
        'untouched' => '  leave me alone  ',
    ]);

    expect($entity->trimmed)->toBe('keep me tidy')
        ->and($entity->untouched)->toBe('  leave me alone  ');
});

it('can trim all mapped string properties from a class attribute', function () {
    $entity = new TrimmedClassEntity([
        'trimmed' => '  tidy me  ',
        'upperCaseString' => '  make me loud  ',
    ]);

    expect($entity->trimmed)->toBe('tidy me')
        ->and($entity->upperCaseString)->toBe('MAKE ME LOUD');
});
