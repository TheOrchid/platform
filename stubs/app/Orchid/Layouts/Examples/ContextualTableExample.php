<?php

namespace App\Orchid\Layouts\Examples;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Screen\Components\Cells\Currency;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ContextualTableExample extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected string $target = 'contextual';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     * @throws \ReflectionException
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->width('100')
                ->render(fn (Repository $model) => // Please use view('path')
                "<img src='https://loremflickr.com/500/300?random={$model->get('id')}'
                              alt='sample'
                              class='mw-100 d-block img-fluid rounded-1 w-100'>
                            <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>"),

            TD::make('name', 'Name')
                ->width('450')
                ->render(fn (Repository $model) => Str::limit($model->get('name'), 200)),

            TD::make('price', 'Price')
                ->width('100')
                ->usingComponent(Currency::class, before: '$')
                ->align(TD::ALIGN_RIGHT),

            TD::make('created_at', 'Created')
                ->width('100')
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT),
        ];
    }

    protected function contextual(Repository|Model|string $row): Color
    {
        return match (true) {
            $row->get('price') > 700 => Color::DANGER,
            $row->get('price') < 1 => Color::SUCCESS,
            default => Color::DEFAULT,
        };
    }

}
