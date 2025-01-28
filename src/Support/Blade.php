<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\AnonymousComponent;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Illuminate\View\Component as ViewComponent;

class Blade
{
    private static array $components = [];

    /**
     * Used to render a Blade component from a class and an array of data
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function renderComponent(string $class, mixed $data): ?string
    {
        $component = static::resolveComponent($class, (array) $data);

        if (! $component->shouldRender()) {
            return null;
        }

        $view = $component->resolveView();

        if ($view instanceof \Closure) {
            $view = $component->resolveView()($component->data());

            return view($view)->render();
        }

        if ($view instanceof View) {
            return $view->with($component->data())->render();
        }

        if ($view instanceof Htmlable) {
            return $view->toHtml();
        }

        return view($view)->with($component->data())->render();
    }

    /**
     * Get instance of the ViewComponent based on the provided class and data
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return ViewComponent
     */
    public static function resolveComponent(string $component, mixed $data): ViewComponent
    {
        [$class, $view] = static::componentInfo($component);

        if ($view !== null) {
            $data = ['view' => $view, 'data' => $data];
        }

        return resolve($class, $data);
    }

    /**
     * Get information about a component
     *
     * Response is array with two elements:
     *  0 - class name of component
     *  1 - view used only for anonymous components
     */
    public static function componentInfo(string $component): array
    {
        return static::$components[$component] ??= static::detectComponentInfo($component);
    }

    private static function detectComponentInfo(string $component): array
    {
        if (is_subclass_of($component, ViewComponent::class)) {
            return [$component, null];
        }

        $view = static::compiler()->componentClass($component);

        return is_subclass_of($view, ViewComponent::class) ? [$view, null] : [AnonymousComponent::class, $view];
    }

    /**
     * Get an instance of the Blade tag compiler.
     */
    private static function compiler(): ComponentTagCompiler
    {
        return new ComponentTagCompiler(
            app('blade.compiler')->getClassComponentAliases(),
            app('blade.compiler')->getClassComponentNamespaces(),
            app('blade.compiler')
        );
    }
}
