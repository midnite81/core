<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping\Account;

it('can auto-map', function () {
    $data = [
        'accountName' => 'Test Account',
        'accountNumber' => 123456,
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
    ];

    $account = new Account($data);

    expect($account->accountName)->toBe('Test Account')
        ->and($account->accountNumber)->toBe(123456)
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
        ->and($account->orders[1]->orderDate->format('Y-m-d'))->toBe('2021-01-02');

    dd($account->toJson());
});
