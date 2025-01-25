<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Support\Arr;
use Illuminate\View\View;
use JsonSerializable;

/**
 * Class Layout.
 */
abstract class Layout implements JsonSerializable
{
    use CanSee;

    /**
     * The Main template to display the layer
     * Represents the view() argument.
     *
     */
    protected string $template;

    /**
     * Nested layers that should be
     * displayed along with it.
     *
     * @var Layout[]
     */
    protected array $layouts = [];

    protected array $variables = [];

    protected Repository $query;

    abstract public function build(Repository $repository): View|string|null;

    protected function buildAsDeep(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $build = collect($this->layouts)
            ->map(fn ($layouts) => Arr::wrap($layouts))
            ->map(fn (iterable $layouts, string $key) => $this->buildChild($layouts, $key, $repository))
            ->collapse()
            ->all();

        $variables = array_merge($this->variables, [
            'templateSlug' => $this->getSlug(),
            'manyForms'    => $build,
        ]);

        return view($this->template, $variables);
    }

    /**
     * @param array $layouts
     * @param int|string $key
     * @param Repository $repository
     * @return array
     */
    protected function buildChild(iterable $layouts, int|string $key, Repository $repository): array
    {
        return collect($layouts)
            ->flatten()
            ->map(fn ($layout) => is_object($layout) ? $layout : resolve($layout))
            ->filter(fn () => $this->isSee())
            ->reduce(function ($build, self $layout) use ($key, $repository) {
                $build[$key][] = $layout->build($repository);

                return $build;
            }, []);
    }

    /**
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     */
    public function getSlug(): string
    {
        return sha1(json_encode($this));
    }

    public function findBySlug(string $slug): ?Layout
    {
        if ($slug === $this->getSlug()) {
            return $this;
        }

        // Trying to find the right layer inside
        return collect($this->layouts)
            ->flatten()
            ->map(static function ($layout) use ($slug) {
                $layout = is_object($layout)
                    ? $layout
                    : resolve($layout);

                return $layout->findBySlug($slug);
            })
            ->filter()
            ->filter(static fn ($layout) => $slug === $layout->getSlug())
            ->first();
    }

    public function findByType(string $type): ?Layout
    {
        if (is_subclass_of($this, $type)) {
            return $this;
        }

        // Trying to find the right layer inside
        return collect($this->layouts)
            ->flatten()
            ->map(fn ($layout) => is_object($layout) ? $layout : resolve($layout))
            ->map(fn (Layout $layout) => $layout->findByType($type))
            ->filter()
            ->first();
    }

    public function jsonSerialize(): array
    {
        $props = collect(get_object_vars($this));

        return $props->except(['query'])->toArray();
    }
}
