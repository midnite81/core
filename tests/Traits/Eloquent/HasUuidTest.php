<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Midnite81\Core\Traits\Eloquent\HasUuid;


test('it generates a UUID on creating', function () {
    $model = new class extends Model {
        use HasUuid;
    };

    // Simulate the "creating" event
    $model->bootHasUUID();

    expect($model)->toBeInstanceOf(Model::class);
});

test('it returns the correct UUID column', function () {
    $model = new class {
        use HasUuid;
    };

    expect($model->getUuidColumn())->toBe('uuid');
});

test('it returns the correct custom UUID column', function () {
    $model = new class {
        use HasUuid;

        public function getUuidColumn(): string
        {
            return 'custom_uuid_column';
        }
    };

    expect($model->getUuidColumn())->toBe('custom_uuid_column');
});
