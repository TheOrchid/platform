<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Support\Blade;
use Illuminate\View\View;

/**
 * Class Component.
 */
abstract class Component extends Layout
{

    private string $component;

    private array $data = [];

    /**
     * Component constructor.
     */
    public function __construct(string $component)
    {
        $this->component = $component;
    }

    /**
     * @param Repository $repository
     * @return View|null
     * @throws BindingResolutionException
     */
    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $data = array_merge($repository->toArray(), $this->data);

        $component = Blade::resolveComponent($this->component, $data);

        if (! $component->shouldRender()) {
            return null;
        }

        $resolve = $component->resolveView();

        $view = is_string($resolve) ? view($resolve) : $resolve;

        return $view->with($component->data());
    }

    public function with(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }
}
