<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Collection;

trait ManagesSearch
{
    /**
     * A registry of all registered permissions, grouped by category.
     *
     * @var array<string, array<string, mixed>>
     */
    protected static array $registeredSearchModels = [];

    /**
     * Registers a set of models for which full-text search is required.
     *
     * @param array $models
     *
     * @return static
     */
    public function registerSearch(array $models): static
    {
        static::$registeredSearchModels = array_merge(static::$registeredSearchModels, $models);

        return $this;
    }

    /**
     * Get the list of searchable models, ensuring uniqueness and resolving model instances.
     *
     * @return Collection The collection of searchable models.
     */
    public function getSearch(): Collection
    {
        return collect(static::$registeredSearchModels)
            ->unique()
            ->transform(static fn ($model) => is_object($model) ? $model : resolve($model));
    }
}
