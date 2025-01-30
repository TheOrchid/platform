<?php

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use InvalidArgumentException;

class ReorderHandle extends TD
{
    protected string $action = '';

    protected string $icon = 'menu';

    protected string $failureMessage;

    protected string $successMessage;

    public function buildTd($repository, ?object $loop = null): Factory|View
    {
        $value = $this->render ? $this->handler($repository, $loop) : $repository->getContent($this->name);

        return view('platform::partials.layouts.reorderHandle', [
            'action'  => $this->action,
            'align'   => $this->align,
            'colspan' => $this->colspan,
            'failure' => $this->failureMessage ?? __('Item move failed'),
            'icon'    => $this->icon,
            'slug'    => $this->sluggable(),
            'success' => $this->successMessage ?? __('Item successfully moved'),
            'value'   => $value,
            'width'   => $this->width,
        ]);
    }

    public function action(string $url): static
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Argument #1 ($url) must be a URL');
        }

        $this->action = $url;

        return $this;
    }

    public function icon(string $name): static
    {
        $this->icon = $name;

        return $this;
    }

    public function messages(string $success, string $failure): static
    {
        $this->failureMessage = $failure;
        $this->successMessage = $success;

        return $this;
    }

    public function method(string $name, array $parameters = []): static
    {
        $url = request()->header('ORCHID-ASYNC-REFERER', url()->current());
        $query = http_build_query($parameters);

        $this->action = rtrim("{$url}/{$name}?{$query}", '/?');

        return $this;
    }
}
