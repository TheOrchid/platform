<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\ContextualTableExample;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\Currency;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ExampleScreen extends Screen
{
    /**
     * Fish text for the table.
     */
    public const TEXT_EXAMPLE = 'Lorem ipsum at sed ad fusce faucibus primis, potenti inceptos ad taciti nisi tristique
    urna etiam, primis ut lacus habitasse malesuada ut. Lectus aptent malesuada mattis ut etiam fusce nec sed viverra,
    semper mattis viverra malesuada quam metus vulputate torquent magna, lobortis nec nostra nibh sollicitudin
    erat in luctus.';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'charts'  => [
                [
                    'name'   => 'Some Data',
                    'values' => [25, 40, 30, 35, 8, 52, 17],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'Another Set',
                    'values' => [25, 50, -10, 15, 18, 32, 27],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'Yet Another',
                    'values' => [15, 20, -3, -15, 58, 12, -17],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'And Last',
                    'values' => [10, 33, -8, -3, 70, 20, -34],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
            ],
            'table'   => [
                new Repository(['id' => 100, 'name' => self::TEXT_EXAMPLE, 'price' => 10.24, 'created_at' => '01.01.2020']),
                new Repository(['id' => 200, 'name' => self::TEXT_EXAMPLE, 'price' => 65.9, 'created_at' => '01.01.2020']),
                new Repository(['id' => 300, 'name' => self::TEXT_EXAMPLE, 'price' => 754.2, 'created_at' => '01.01.2020']),
                new Repository(['id' => 400, 'name' => self::TEXT_EXAMPLE, 'price' => 0.1, 'created_at' => '01.01.2020']),
                new Repository(['id' => 500, 'name' => self::TEXT_EXAMPLE, 'price' => 0.15, 'created_at' => '01.01.2020']),

            ],
            'contextual'   => [
                new Repository(['id' => 100, 'name' => self::TEXT_EXAMPLE, 'price' => 10.24, 'created_at' => '01.01.2020']),
                new Repository(['id' => 200, 'name' => self::TEXT_EXAMPLE, 'price' => 65.9, 'created_at' => '01.01.2020']),
                new Repository(['id' => 300, 'name' => self::TEXT_EXAMPLE, 'price' => 754.2, 'created_at' => '01.01.2020']),
                new Repository(['id' => 400, 'name' => self::TEXT_EXAMPLE, 'price' => 0.1, 'created_at' => '01.01.2020']),
                new Repository(['id' => 500, 'name' => self::TEXT_EXAMPLE, 'price' => 0.15, 'created_at' => '01.01.2020']),

            ],
            'metrics' => [
                'sales'    => ['value' => number_format(6851), 'diff' => 10.08],
                'visitors' => ['value' => number_format(24668), 'diff' => -30.76],
                'orders'   => ['value' => number_format(10000), 'diff' => 0],
                'total'    => number_format(65661),
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Example Screen';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Sample Screen Components';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Show toast')
                ->method('showToast')
                ->novalidate()
                ->icon('bs.chat-square-dots'),

            ModalToggle::make('Launch demo modal')
                ->modal('exampleModal')
                ->method('showToast')
                ->icon('bs.window'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Sales Today'    => 'metrics.sales',
                'Visitors Today' => 'metrics.visitors',
                'Pending Orders' => 'metrics.orders',
                'Total Earnings' => 'metrics.total',
            ]),

            Layout::columns([
                ChartLineExample::make('charts', 'Line Chart')
                    ->description('Visualize data trends with multi-colored line graphs.'),

                ChartBarExample::make('charts', 'Bar Chart')
                    ->description('Compare data sets with colorful bar graphs.'),
            ]),

            Layout::table('table', [
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
            ]),

            ContextualTableExample::class,

            Layout::modal('exampleModal', Layout::rows([
                Input::make('toast')
                    ->title('Messages to display')
                    ->placeholder('Hello world!')
                    ->help('The entered text will be displayed on the right side as a toast.')
                    ->required(),
            ]))->title('Create your own toast message'),
        ];
    }

    public function showToast(Request $request): void
    {
        Toast::warning($request->get('toast', 'Hello, world! This is a toast message.'));
    }
}
