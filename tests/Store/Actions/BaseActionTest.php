<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Midnite81\Core\Store\Actions\BaseAction;

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('can store data to the model', function () {
    $data = ['name' => 'John Doe'];
    $modelMock = \Mockery::mock(Model::class);
    $queryBuilderMock = \Mockery::mock(Builder::class);
    $queryBuilderMock->shouldReceive('create')->with($data)->andReturn($modelMock);

    $modelMock->shouldReceive('newQuery')->andReturn($queryBuilderMock);

    $action = new class($modelMock) extends BaseAction {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function store(array $data): Model
        {
            return $this->internalStore($data);
        }
    };
    
    $result = $action->store($data);
    
    expect($result)->toBe($modelMock);
});

it('can update data to the passed model', function () {
    $data = ['name' => 'Updated John Doe'];
    $modelMock = \Mockery::mock(Model::class);
    $modelMock->shouldReceive('update')->with($data)->andReturn(true);

    $action = new class($modelMock) extends BaseAction {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function update(Model $model, array $data): bool
        {
            return $this->internalUpdate($model, $data);
        }
    };
    
    $result = $action->update($modelMock, $data);
    
    expect($result)->toBeTrue();
});

it('can update or create a record', function () {
    $attributes = ['email' => 'john@example.com'];
    $data = ['name' => 'John Doe'];
    $modelMock = \Mockery::mock(Model::class);
    $queryBuilderMock = \Mockery::mock(Builder::class);
    $queryBuilderMock->shouldReceive('updateOrCreate')->with($attributes, $data)->andReturn($modelMock);

    $modelMock->shouldReceive('newQuery')->andReturn($queryBuilderMock);

    $action = new class($modelMock) extends BaseAction {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function updateOrCreate(array $attributes, array $data): Model
        {
            return $this->internalUpdateOrCreate($attributes, $data);
        }
    };
    
    $result = $action->updateOrCreate($attributes, $data);
    
    expect($result)->toBe($modelMock);
});
