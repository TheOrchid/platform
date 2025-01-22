<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\NumberRange;
use Orchid\Screen\Fields\Select;

class TD extends Cell
{
    /**
     * Align the cell to the left.
     */
    public const ALIGN_LEFT = 'start';
    /**
     * Align the cell to the center.
     */
    public const ALIGN_CENTER = 'center';
    /**
     * Align the cell to the right.
     */
    public const ALIGN_RIGHT = 'end';
    public const FILTER_TEXT = 'text';
    public const FILTER_NUMERIC = 'number';
    public const FILTER_DATE = 'date';
    public const FILTER_DATE_RANGE = 'dateRange';
    public const FILTER_NUMBER_RANGE = 'numberRange';
    public const FILTER_SELECT = 'select';
    public const FILTER_SELECT_NOT_MULTIPLE = 'selectNotMultiple';
    /**
     * @var string|null|int
     */
    protected $width;
    /**
     * @var string|null
     */
    protected $style;
    /**
     * @var string|null
     */
    protected $class;
    /**
     * @var string
     */
    protected $filter;
    /**
     * @var bool
     */
    protected $sort;
    /**
     * @var string
     */
    protected $align = self::ALIGN_LEFT;
    /**
     * @var int
     */
    protected $colspan = 1;
    /**
     * Displays whether the user can hide
     * or show the column in the browser.
     *
     * @var bool
     */
    protected $allowUserHidden = true;
    /**
     * Should the user independently enable
     * the display of the column.
     *
     * @var bool
     */
    protected $defaultHidden = false;
    /**
     * Possible options for filters if it's select
     *
     * @var array
     */
    protected $filterOptions = [];

    /**
     * Callable return filter value in column
     *
     * @var callable
     */
    protected $callbackFilterValue;

    /**
     * @param string|int $width
     */
    public function width($width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param string $style
     */
    public function style($style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @param string $class
     */
    public function class($class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param string|\Orchid\Screen\Field $filter
     */
    public function filterOptions(iterable $filterOptions): self
    {
        $this->filterOptions = $filterOptions;

        return $this;
    }

    public function filterValue(callable $callable): self
    {
        $this->callbackFilterValue = $callable;

        return $this;
    }

    /**
     * @param string                 $filter
     * @param iterable|callable|null $options
     */
    public function filter($filter = self::FILTER_TEXT, $options = null): self
    {
        if (is_iterable($options)) {
            $this->filterOptions($options);
        }

        if (is_callable($options)) {
            $this->callbackFilterValue = $options;
        }

        $this->filter = $filter;

        return $this;
    }

    public function sort(bool $sort = true): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return $this
     */
    public function align(string $align): self
    {
        $this->align = $align;

        return $this;
    }

    /**
     * @return $this
     */
    public function alignLeft(): self
    {
        $this->align = self::ALIGN_LEFT;

        return $this;
    }

    /**
     * @return $this
     */
    public function alignRight(): self
    {
        $this->align = self::ALIGN_RIGHT;

        return $this;
    }

    /**
     * @return $this
     */
    public function alignCenter(): self
    {
        $this->align = self::ALIGN_CENTER;

        return $this;
    }

    /**
     * @return $this
     */
    public function colspan(int $colspan): self
    {
        $this->colspan = $colspan;

        return $this;
    }

    /**
     * Builds a column heading.
     *
     * @return Factory|View
     */
    public function buildTh()
    {
        return view('platform::partials.layouts.th', [
            'width'        => is_numeric($this->width) ? $this->width.'px' : $this->width,
            'align'        => $this->align,
            'sort'         => $this->sort,
            'sortUrl'      => $this->buildSortUrl(),
            'column'       => $this->column,
            'title'        => $this->title,
            'filter'       => $this->buildFilter(),
            'filterString' => $this->buildFilterString(),
            'slug'         => $this->sluggable(),
            'popover'      => $this->popover,
        ]);
    }

    /**
     * @return \Orchid\Screen\Field|null
     */
    protected function buildFilter(): ?Field
    {
        /** @var \Orchid\Screen\Field $filter|string */
        $filter = $this->filter;

        if ($filter === null) {
            return null;
        }

        if (is_string($filter)) {
            $filter = $this->detectConstantFilter($filter);
        }

        return $filter->name("filter[$this->column]")
            ->placeholder(__('Filter'))
            ->form('filters')
            ->value(get_filter($this->column))
            ->autofocus();
    }

    /**
     * @return \Orchid\Screen\Field
     */
    protected function detectConstantFilter(string $filter): Field
    {
        $input = match ($filter) {
            self::FILTER_DATE_RANGE          => DateRange::make()->disableMobile(),
            self::FILTER_NUMBER_RANGE        => NumberRange::make(),
            self::FILTER_SELECT              => Select::make()->options($this->filterOptions)->multiple(),
            self::FILTER_DATE                => DateTimer::make()->format('Y-m-d'),
            self::FILTER_SELECT_NOT_MULTIPLE => Select::make()->options($this->filterOptions)->empty(),
            default                          => Input::make()->type($filter),
        };

        return $input;
    }

    /**
     * Builds content for the column.
     *
     * @param Repository|Model $repository
     *
     * @return Factory|View
     */
    public function buildTd($repository, ?object $loop = null)
    {
        $value = $this->render ? $this->handler($repository, $loop) : $repository->getContent($this->name);

        return view('platform::partials.layouts.td', [
            'align'   => $this->align,
            'value'   => $value,
            'render'  => $this->render,
            'slug'    => $this->sluggable(),
            'width'   => is_numeric($this->width) ? $this->width.'px' : $this->width,
            'style'   => $this->style,
            'class'   => $this->class,
            'colspan' => $this->colspan,
        ]);
    }

    public function isAllowUserHidden(): bool
    {
        return $this->allowUserHidden;
    }

    /**
     * Builds an item menu for show/hiden column.
     *
     * @return Factory|View|null
     */
    public function buildItemMenu()
    {
        if (! $this->isAllowUserHidden()) {
            return;
        }

        return view('platform::partials.layouts.selectedTd', [
            'title'         => $this->title,
            'slug'          => $this->sluggable(),
            'defaultHidden' => var_export($this->defaultHidden, true),
        ]);
    }

    protected function sluggable(): string
    {
        return Str::slug($this->name);
    }

    /**
     * Prevents the user from hiding a column in the interface.
     */
    public function cantHide(bool $hidden = false): self
    {
        $this->allowUserHidden = $hidden;

        return $this;
    }

    /**
     * @return $this
     */
    public function defaultHidden(bool $hidden = true): self
    {
        $this->defaultHidden = $hidden;

        return $this;
    }

    public function buildSortUrl(): string
    {
        $query = request()->collect()->put('sort', revert_sort($this->column))->toArray();

        return url()->current().'?'.http_build_query($query);
    }

    /**
     * @param TD[] $columns
     */
    public static function isShowVisibleColumns($columns): bool
    {
        return collect($columns)->filter(fn ($column) => $column->isAllowUserHidden())->isNotEmpty();
    }

    /**
     * @deprecated is not usage
     *
     * Decides whether a filter can be provided with a complex (array-like) value, or it needs a scalar one.
     *
     * @param \Orchid\Screen\Field $field
     */
    protected function isComplexFieldType(Field $field): bool
    {
        return $field instanceof ComplexFieldConcern;
    }

    protected function buildFilterString(): ?string
    {
        $filter = get_filter($this->column);

        if ($filter === null) {
            return null;
        }

        if ($this->callbackFilterValue !== null) {
            return call_user_func($this->callbackFilterValue, $filter);
        }

        if (is_array($filter)) {
            if (isset($filter['start']) || isset($filter['end'])) {
                return ($filter['start'] ?? '').' - '.($filter['end'] ?? '');
            }

            if ($this->filterOptions) {
                $filter = array_map(fn ($val) => $this->filterOptions[$val] ?? $val, $filter);
            }

            return implode(', ', $filter);
        }

        return $this->filterOptions[$filter] ?? $filter;
    }
}
