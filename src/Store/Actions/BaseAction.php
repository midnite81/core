<?php

declare(strict_types=1);

namespace Midnite81\Core\Store\Actions;

use Illuminate\Database\Eloquent\Model;

abstract class BaseAction
{
    /**
     * The model which the action is based upon.
     * To be set at extended class level
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Store data to the model
     *
     * @param array $data
     * @return Model
     */
    protected function internalStore(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * Update data to the passed model
     *
     * @param Model $model
     * @param array $data
     * @return bool
     */
    protected function internalUpdate(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * Updates or creates a record
     *
     * @param array $attributes
     * @param array $data
     * @return Model
     */
    protected function internalUpdateOrCreate(array $attributes, array $data): Model
    {
        return $this->model->newQuery()->updateOrCreate($attributes, $data);
    }
}
