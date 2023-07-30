<?php

declare(strict_types=1);

use Midnite81\Core\Enums\Algorithm;
use Midnite81\Core\Tests\CoreTestCase;
use Midnite81\Core\Tests\Entities\TestHelpers\ChecksumEntity;
use Midnite81\Core\Tests\Entities\TestHelpers\ChecksumEntity2;

uses(CoreTestCase::class);

it('provides a checksum', function () {
    $entity = new ChecksumEntity();
    $entity->id = 2942;
    $entity->name = 'Dave';

    expect($entity->checksum())
        ->toBe('0d3cba1627c035e0beb87a70c96f6d6840442c9b783e414ed7b0fb315b4ba45b')
        ->and($entity->checksum(Algorithm::Sha1))
        ->toBe('f38108657a85347c31f171cb9ab56ad5ee9530e7')
        ->and($entity->checksum(Algorithm::Sha224))
        ->toBe('345f30ed5f6bf46ee947bb67a2422e682df1061b534343782f986052')
        ->and($entity->checksum(Algorithm::Sha256))
        ->toBe('0d3cba1627c035e0beb87a70c96f6d6840442c9b783e414ed7b0fb315b4ba45b')
        ->and($entity->checksum(Algorithm::Sha384))
        ->toBe('ea54bd3c85e04a58656a021249f23281da88edf9126d44c51f9856bcd51853ee24035323445b4138c4fdac1d8ac81eca')
        ->and($entity->checksum(Algorithm::Sha512))
        ->toBe('d884e213b144dad877154c62b5cab578bf84d143e5aef47c9d12b0b50b4d0181c06c9fd5cab4cd4b45ee961af7d1e1c59de02185515434e766763d24e0125f21');
});

it('it has different checksums', function () {
    $entity = new ChecksumEntity();
    $entity->id = 2942;
    $entity->name = 'Dave';

    $entity2 = new ChecksumEntity();
    $entity2->id = 2942;
    $entity2->name = 'Dave2';

    expect($entity->checksum())->not()->toBe($entity2->checksum());
});

it('checks the checksum', function () {
    $entity = new ChecksumEntity();
    $entity->id = 2942;
    $entity->name = 'Dave';

    expect($entity->verifyChecksum('0d3cba1627c035e0beb87a70c96f6d6840442c9b783e414ed7b0fb315b4ba45b'))
        ->toBeTrue()
        ->and($entity->verifyChecksum('f38108657a85347c31f171cb9ab56ad5ee9530e7', Algorithm::Sha1))
        ->toBeTrue()
        ->and($entity->verifyChecksum('345f30ed5f6bf46ee947bb67a2422e682df1061b534343782f986052', Algorithm::Sha224))
        ->toBeTrue()
        ->and($entity->verifyChecksum('0d3cba1627c035e0beb87a70c96f6d6840442c9b783e414ed7b0fb315b4ba45b', Algorithm::Sha256))
        ->toBeTrue()
        ->and($entity->verifyChecksum('ea54bd3c85e04a58656a021249f23281da88edf9126d44c51f9856bcd51853ee24035323445b4138c4fdac1d8ac81eca', Algorithm::Sha384))
        ->toBeTrue()
        ->and($entity->verifyChecksum('d884e213b144dad877154c62b5cab578bf84d143e5aef47c9d12b0b50b4d0181c06c9fd5cab4cd4b45ee961af7d1e1c59de02185515434e766763d24e0125f21', Algorithm::Sha512))
        ->toBeTrue();
});

it('can produce a checksum from an array', function () {
    $entity = new ChecksumEntity();
    $entity->id = 2942;
    $entity->name = 'Dave';

    expect($entity->checksum())->toBe('0d3cba1627c035e0beb87a70c96f6d6840442c9b783e414ed7b0fb315b4ba45b');
});

it('can produce a checksum from base method', function () {
    $entity = new ChecksumEntity2();
    $entity->id = 2942;
    $entity->name = 'Dave';

    expect($entity->checksum())->toBe('0d3cba1627c035e0beb87a70c96f6d6840442c9b783e414ed7b0fb315b4ba45b');
});
