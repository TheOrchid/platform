<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Arr;

trait ManagesModelOptions
{
    protected array $registeredReplaceModels = [];

    /**
     * Get the model instance for a given key or class name.
     *
     * @param string      $key
     * @param string|null $default
     *
     * @return mixed
     */
    public function modelClass(string $key, ?string $default = null): mixed
    {
        $model = $this->model($key, $default);

        return class_exists($model) ? new $model : $model;
    }

    /**
     * Get the class name for a given Dashboard model.
     */
    public function model(string $key, ?string $default = null): string
    {
        return Arr::get($this->registeredReplaceModels, $key, $default ?? $key);
    }

    /**
     * Get the user model class name.
     */
    public function useModel(string $key, string $custom): static
    {
        $this->registeredReplaceModels[$key] = $custom;

        return $this;
    }
}
