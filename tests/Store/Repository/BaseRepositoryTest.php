<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Midnite81\Core\Exceptions\Store\RecordNotFoundException;
use Midnite81\Core\Store\Repository\BaseRepository;

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('can get a record by ID', function () {
    $id = 1;
    $modelMock = \Mockery::mock(Model::class);
    $modelMock->shouldReceive('newQuery')->andReturnSelf();
    $modelMock->shouldReceive('where')->with('id', $id)->andReturnSelf();
    $modelMock->shouldReceive('first')->andReturn($modelMock);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function getById(int $id): Model
        {
            return $this->internalGetById($id);
        }
    };

    $result = $repository->getById($id);

    expect($result)->toBe($modelMock);
});

it('throws RecordNotFoundException when getting a non-existent record by ID', function () {
    $id = 99;
    $modelMock = \Mockery::mock(Model::class);
    $modelMock->shouldReceive('newQuery')->andReturnSelf();
    $modelMock->shouldReceive('where')->with('id', $id)->andReturnSelf();
    $modelMock->shouldReceive('first')->andReturn(null);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function getById(int $id): Model
        {
            return $this->internalGetById($id);
        }
    };

    expect(fn() => $repository->getById($id))->toThrow(RecordNotFoundException::class);
});

it('can list all records', function () {
    $modelMock = \Mockery::mock(Model::class);
    $queryBuilderMock = \Mockery::mock(Illuminate\Database\Eloquent\Builder::class);
    $queryBuilderMock->shouldReceive('orderBy')->andReturnSelf();
    $queryBuilderMock->shouldReceive('get')->andReturn(Collection::make([$modelMock]));

    $modelMock->shouldReceive('newQuery')->andReturn($queryBuilderMock);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function listAll(): Collection
        {
            return $this->internalListAll();
        }
    };

    $result = $repository->listAll();

    expect($result)->toBeInstanceOf(Collection::class)
                   ->and($result->count())->toBe(1);
});

it('can get a record by column and identifier', function () {
    $column = 'name';
    $identifier = 'John Doe';
    $modelMock = Mockery::mock(Model::class);
    $modelMock->shouldReceive('newQuery')->andReturnSelf();
    $modelMock->shouldReceive('where')->with($column, $identifier)->andReturnSelf();
    $modelMock->shouldReceive('first')->andReturn($modelMock);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function getByColumn(string $column, string $identifier): Model
        {
            return $this->internalGetByColumn($column, $identifier);
        }
    };

    $result = $repository->getByColumn($column, $identifier);

    expect($result)->toBe($modelMock);
});

it('throws RecordNotFoundException when getting a non-existent record by column and identifier', function () {
    $column = 'name';
    $identifier = 'John Doe';
    $modelMock = Mockery::mock(Model::class);
    $modelMock->shouldReceive('newQuery')->andReturnSelf();
    $modelMock->shouldReceive('where')->with($column, $identifier)->andReturnSelf();
    $modelMock->shouldReceive('first')->andReturn(null);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function getByColumn(string $column, string $identifier): Model
        {
            return $this->internalGetByColumn($column, $identifier);
        }
    };

    $this->expectException(RecordNotFoundException::class);
    $repository->getByColumn($column, $identifier);
});

it('can list records by column and value', function () {
    $column = 'category_id';
    $values = [1, 2, 3];
    $modelMock = Mockery::mock(Model::class);
    $queryBuilderMock = Mockery::mock(Illuminate\Database\Eloquent\Builder::class);
    $queryBuilderMock->shouldReceive('orderBy')->andReturnSelf();
    $queryBuilderMock->shouldReceive('whereIn')->with($column, $values)->andReturnSelf();
    $queryBuilderMock->shouldReceive('get')->andReturn(Collection::make([$modelMock]));

    $modelMock->shouldReceive('newQuery')->andReturn($queryBuilderMock);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function listByColumn(string $column, array $values): Collection
        {
            return $this->internalListByColumn($column, $values);
        }
    };

    $result = $repository->listByColumn($column, $values);

    expect($result)->toBeInstanceOf(Collection::class)
                   ->and($result->count())->toBe(1);
});

it('can list records by column and single value', function () {
    $column = 'status';
    $value = 'active';
    $modelMock = Mockery::mock(Model::class);
    $queryBuilderMock = Mockery::mock(Illuminate\Database\Eloquent\Builder::class);
    $queryBuilderMock->shouldReceive('newQuery')->andReturnSelf();
    $queryBuilderMock->shouldReceive('orderBy')->andReturnSelf();
    $queryBuilderMock->shouldReceive('where')->with($column, $value)->andReturnSelf();
    $queryBuilderMock->shouldReceive('get')->andReturn(Collection::make([$modelMock]));

    $modelMock->shouldReceive('newQuery')->andReturn($queryBuilderMock);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function listByColumn(string $column, string $value): Collection
        {
            return $this->internalListByColumn($column, $value);
        }
    };

    $result = $repository->listByColumn($column, $value);

    expect($result)->toBeInstanceOf(Collection::class)
                   ->and($result->count())->toBe(1);
});

it('can list ordered records by column and single value', function () {
    $column = 'status';
    $value = 'active';
    $orderBy = ['column' => 'asc'];
    $modelMock = Mockery::mock(Model::class);
    $modelMock->shouldReceive('newQuery')->andReturnSelf();
    $modelMock->shouldReceive('orderBy')->andReturnSelf();
    $modelMock->shouldReceive('where')->andReturnSelf();
    $modelMock->shouldReceive('get')->andReturn(Collection::make([]));
    $queryBuilderMock = Mockery::mock(Illuminate\Database\Eloquent\Builder::class);
    $queryBuilderMock->shouldReceive('newQuery')->andReturnSelf();
    $queryBuilderMock->shouldReceive('orderBy')->andReturnSelf();
    $queryBuilderMock->shouldReceive('where')->with($column, $value)->andReturnSelf();
    $queryBuilderMock->shouldReceive('get')->andReturn(Collection::make([$modelMock]));

    $modelMock->shouldReceive('newQuery')->andReturn($queryBuilderMock);

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function listByColumn(string $column, string $value): Collection
        {
            return $this->internalListByColumn($column, $value);
        }

        public function getOrderBy(): array
        {
            return $this->orderBy;
        }

        public function orderBy(array $orderBy): self
        {
            return $this->setOrderBy($orderBy);
        }
    };

    $result = $repository->orderBy($orderBy)->listByColumn($column, $value);

    expect($result)->toBeInstanceOf(Collection::class)
                   ->and($result->count())->toBe(0);
});

it('can set the order by clause', function () {
    $orderBy = ['column' => 'asc'];
    $modelMock = Mockery::mock(Model::class);
    $modelMock->shouldReceive('newQuery')->andReturnSelf();
    $modelMock->shouldReceive('orderBy')->andReturnSelf();
    $modelMock->shouldReceive('get')->andReturn(Collection::make([]));

    $repository = new class($modelMock) extends BaseRepository {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function listAll(): Collection
        {
            return $this->internalListAll();
        }

        public function getOrderBy(): array
        {
            return $this->orderBy;
        }

        public function orderBy(array $orderBy): self
        {
            return $this->setOrderBy($orderBy);
        }
    };

    $result = $repository->orderBy($orderBy)->listAll();

    expect($result)->toBeInstanceOf(Collection::class)
                   ->and($repository->getOrderBy())->toBe($orderBy);
});
