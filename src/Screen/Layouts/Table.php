<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Color;

abstract class Table extends Layout
{
    protected string $template = 'platform::layouts.table';

    protected Repository $query;

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     */
    protected string $target;

    /**
     * The string to be displayed on top of the table.
     */
    protected ?string $title = null;

    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $columns = collect($this->columns())->filter(static fn (TD $column) => $column->isSee());

        $total = collect($this->total())->filter(static fn (TD $column) => $column->isSee());

        $content = $repository->getContent($this->target);

        $rows = is_a($content, Paginator::class) || is_a($content, CursorPaginator::class) ? $content : collect()->merge($content);

        return view($this->template, [
            'repository'   => $repository,
            'rows'         => $rows,
            'columns'      => $columns,
            'total'        => $total,
            'iconNotFound' => $this->iconNotFound(),
            'textNotFound' => $this->textNotFound(),
            'subNotFound'  => $this->subNotFound(),
            'striped'      => $this->striped(),
            'compact'      => $this->compact(),
            'bordered'     => $this->bordered(),
            'hoverable'    => $this->hoverable(),
            'slug'         => $this->getSlug(),
            'onEachSide'   => $this->onEachSide(),
            'showHeader'   => $this->hasHeader($columns, $rows),
            'title'        => $this->title,
            'contextual'   => fn($row) => $this->contextual($row),
        ]);
    }

    public function title(?string $title = null): static
    {
        $this->title = $title;

        return $this;
    }

    protected function iconNotFound(): string
    {
        return 'bs.journal-x';
    }

    protected function textNotFound(): string
    {
        if (count(request()->query()) !== 0) {
            return __('No results found for your current filters');
        }

        return __('There are no objects currently displayed');
    }

    protected function subNotFound(): string
    {
        if (count(request()->query()) !== 0) {
            return __('Try adjusting your filter settings or removing it altogether to see more data');
        }

        return __('Import or create objects, or check back later for updates');
    }

    /**
     * Usage for zebra-striping to any table row.
     */
    protected function striped(): bool
    {
        return false;
    }

    /**
     * Usage for compact display of table rows.
     */
    protected function compact(): bool
    {
        return false;
    }

    /**
     * Usage for borders on all sides of the table and cells.
     */
    protected function bordered(): bool
    {
        return false;
    }

    /**
     * Enable a hover state on table rows.
     */
    protected function hoverable(): bool
    {
        return false;
    }

    /**
     * The number of links to display on each side of the current page link.
     */
    protected function onEachSide(): int
    {
        return 3;
    }

    /**
     * @param \Illuminate\Support\Collection|Illuminate\Contracts\Pagination\Paginator|Illuminate\Contracts\Pagination\CursorPaginator $row
     */
    protected function hasHeader(Collection $columns, Collection|Paginator|CursorPaginator $row): bool
    {
        if ($columns->count() < 2) {
            return false;
        }

        return ! empty(request()->query()) || $row->isNotEmpty();
    }

    abstract protected function columns(): iterable;

    protected function total(): array
    {
        return [];
    }

    /**
     * A method that processes a string and returns the color of the string.
    */
    protected function contextual(Repository|Model|string $row): Color
    {
       return Color::DEFAULT;
    }

}
