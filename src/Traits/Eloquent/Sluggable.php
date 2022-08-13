<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Eloquent;

use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * Register the model events for adding the slug.
     */
    public static function bootSluggable(): void
    {
        static::created(function ($model) {
            if ($model->shouldRunEvent($model, 'created')) {
                $model->{$model->getSlugColumn()} = $model->buildSlug();
                $model->save();
            }
        });

        static::updating(function ($model) {
            if ($model->shouldRunEvent($model, 'updating')) {
                $model->{$model->getSlugColumn()} = $model->buildSlug();
            }
        });

        static::saving(function ($model) {
            if ($model->shouldRunEvent($model, 'saving')) {
                $model->{$model->getSlugColumn()} = $model->buildSlug();
            }
        });
    }

    /**
     * This is the column the slug is stored to
     */
    public function getSlugColumn(): string
    {
        return 'slug';
    }

    /**
     * Return the column the slug should be based on
     *
     * @return string
     */
    public function getSluggableColumn(): string
    {
        return 'name';
    }

    /**
     * Build the slug
     *
     * @return string
     */
    public function buildSlug(): string
    {
        $name = $this->getAttribute($this->getSluggableColumn());

        return Str::slug($name . '-' . $this->getAttribute('id'));
    }

    /**
     * Saves Slug to Model
     *
     * @param $model
     */
    public function saveSlugToModel($model): void
    {
        $model->{$model->getSlugColumn()} = $model->buildSlug();
        $model->save();
    }

    /**
     * Update all slugs
     */
    public function updateSlugs(): void
    {
        $allRecords = $this->all();

        if ($allRecords) {
            foreach ($allRecords as $record) {
                $activeRecord = $this->newQuery()->find($record->id);
                $activeRecord->update([
                    $this->getSlugColumn() => $this->buildSlug(),
                ]);
            }
        }
    }

    /**
     * Checks to see if the event should run
     *
     * @param $model
     * @param $type
     * @return bool
     */
    protected function shouldRunEvent($model, $type): bool
    {
        return property_exists($model, 'sluggableEvents') && in_array($type, $model->sluggableEvents)
            || !property_exists($model, 'sluggableEvents');
    }
}
