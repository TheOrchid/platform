<?php

declare(strict_types=1);

namespace Orchid\Support;

/**
 * Presenter class for presenting data from the Eloquent model
 *
 * This class encapsulates the logic for presenting data in a particular format,
 * allowing for separation and maintainability of the model and view logic.
 */
abstract class Presenter
{
    /**
     * The entity instance to present.
     *
     * @var object
     */
    protected object $entity;

    /**
     * Create a new instance of the presenter.
     *
     * @param object $entity
     */
    public function __construct(object $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Allow for property-style retrieval by calling a corresponding method if exists, or just returning the entity property.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }

    /**
     * Determine if a property exists on the presenter or the entity.
     *
     * @param string $property
     *
     * @return bool
     */
    public function __isset(string $property): bool
    {
        return property_exists($this, $property) || property_exists($this->entity, $property);
    }
}
