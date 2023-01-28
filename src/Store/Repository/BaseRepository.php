<?php

declare(strict_types=1);

namespace Midnite81\Core\Store\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Midnite81\Core\Exceptions\Store\RecordNotFoundException;

abstract class BaseRepository
{
    protected Model $model;

    /**
     * Sort by order
     * example [['column' => 'asc/desc']]
     * @var array<array<string, string>>
     */
    protected array $orderBy = [];

    /**
     * @param  int  $id
     * @return Model|null
     */
    protected function internalTryGetById(int $id): ?Model
    {
        /** @var ?Model $record */
        $record = $this->model->newQuery()->where('id', $id)->first();

        return $record;
    }

    /**
     * @param  int  $id
     * @return Model
     *
     * @throws RecordNotFoundException
     */
    protected function internalGetById(int $id): Model
    {
        $record = $this->internalTryGetById($id);

        if ($record === null) {
            throw new RecordNotFoundException($id);
        }

        return $record;
    }

    /**
     * @param  string  $column
     * @param  string|int  $identifier
     * @return Model|null
     */
    protected function internalTryGetByColumn(string $column, string|int $identifier): ?Model
    {
        /** @var ?Model $record */
        $record = $this->model->newQuery()->where($column, $identifier)->first();

        return $record;
    }

    /**
     * @param  string  $column
     * @param  string|int  $identifier
     * @return Model
     *
     * @throws RecordNotFoundException
     */
    protected function internalGetByColumn(string $column, string|int $identifier): Model
    {
        $record = $this->internalTryGetByColumn($column, $identifier);

        if ($record === null) {
            throw new RecordNotFoundException($identifier);
        }

        return $record;
    }

    /**
     * @return Collection<int, Model>
     */
    protected function internalListAll(): Collection
    {
        $build = $this->model->newQuery();

        if (!empty($this->orderBy)) {
            foreach($this->orderBy as $column => $direction) {
                $build->orderBy($column, $direction);
            }
        }

        return $build->get();
    }

    /**
     * @param $column
     * @param  int|string|array  $value
     * @return Collection<int, Model>
     */
    protected function internalListByColumn($column, int|string|array $value): Collection
    {
        $build = $this->model->newQuery();

        if (!empty($this->orderBy)) {
            foreach($this->orderBy as $column => $direction) {
                $build->orderBy($column, $direction);
            }
        }

        if (is_array($value)) {
            $build->whereIn($column, $value);
        } else {
            $build->where($column, $value);
        }

        return $build->get();
    }


    /**
     * Sort by order
     * example [['column' => 'asc/desc']]
     * @param array $orderBy
     * @return BaseRepository
     */
    protected function setOrderBy(array $orderBy): BaseRepository
    {
        $this->orderBy = $orderBy;
        return $this;
    }
}
