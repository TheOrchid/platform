<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Carbon;
use Orchid\Metrics\GroupCollection;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class MetricsTest extends TestUnitCase
{
    public function testGroupCount(): void
    {
        User::factory()->count(5)->create([
            'name' => true,
        ]);

        User::factory()->count(8)->create([
            'name' => false,
        ]);

        /** @var GroupCollection $group */
        $group = User::countForGroup('name');

        $this->assertContains(8, $group->pluck('value')->toArray());
        $this->assertContains(5, $group->pluck('value')->toArray());

        $this->assertSame([
            [
                'labels' => ['0', '1'],
                'values' => [8, 0],
            ],
            [
                'labels' => ['0', '1'],
                'values' => [0, 5],
            ],
        ], $group->toChart());

        $namedLabel = $group->toChart(static fn (bool $title) => $title ? 'Enabled' : 'Disabled');

        $this->assertSame([
            [
                'labels' => ['Disabled', 'Enabled'],
                'values' => [8, 0],
            ],
            [
                'labels' => ['Disabled', 'Enabled'],
                'values' => [0, 5],
            ],
        ], $namedLabel);
    }

    public function testPeriod(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDays(2);
        $end = (clone $current)->subDay();

        User::factory()->count(5)->create([
            'created_at' => $start,
        ]);

        User::factory()->count(8)->create([
            'created_at' => $end,
        ]);

        $period = User::countByDays($start, $end);

        $this->assertEquals(5, $period->pluck('value')->first());
        $this->assertEquals(8, $period->pluck('value')->last());

        $this->assertEquals($start->toDateString(), $period->pluck('label')->first());
        $this->assertEquals($end->toDateString(), $period->pluck('label')->last());

        $this->assertSame([
            'name'    => 'Users',
            'labels'  => $period->pluck('label')->toArray(),
            'values'  => $period->pluck('value')->toArray(),
        ], $period->toChart('Users'));
    }

    public function testMaxValuesPeriod(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDays(2);
        $end = (clone $current)->subDay();

        User::factory()->count(5)->create([
            'created_at' => $start,
        ]);

        User::factory()->count(8)->create([
            'created_at' => $end,
        ]);

        $period = User::maxByDays('id', $start, $end);

        // Stitch selection depends on database and driver
        $this->assertContains($period->pluck('value')->first(), [5, '5']);
        $this->assertContains($period->pluck('value')->last(), [13, '13']);

        $this->assertEquals($start->toDateString(), $period->pluck('label')->first());
        $this->assertEquals($end->toDateString(), $period->pluck('label')->last());

        $this->assertSame([
            'name'    => 'Users',
            'labels'  => $period->pluck('label')->toArray(),
            'values'  => $period->pluck('value')->toArray(),
        ], $period->toChart('Users'));
    }

    public function testMinValuesPeriod(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDays(2);
        $end = (clone $current)->subDay();

        User::factory()->count(5)->create([
            'created_at' => $start,
        ]);

        User::factory()->count(8)->create([
            'created_at' => $end,
        ]);

        $period = User::minByDays('id', $start, $end);

        // Stitch selection depends on database and driver
        $this->assertContains($period->pluck('value')->first(), [1, '1']);
        $this->assertContains($period->pluck('value')->last(), [6, '6']);

        $this->assertEquals($start->toDateString(), $period->pluck('label')->first());
        $this->assertEquals($end->toDateString(), $period->pluck('label')->last());

        $this->assertSame([
            'name'    => 'Users',
            'labels'  => $period->pluck('label')->toArray(),
            'values'  => $period->pluck('value')->toArray(),
        ], $period->toChart('Users'));
    }

    public function testSumPeriod(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDays(2);
        $end = (clone $current)->subDay();

        User::factory()->count(5)->create([
            'created_at' => $start,
        ]);

        User::factory()->count(8)->create([
            'created_at' => $end,
        ]);

        $period = User::sumByDays('id', $start, $end);

        $this->assertEquals(15, $period->pluck('value')->first());
        $this->assertEquals(76, $period->pluck('value')->last());

        $this->assertEquals($start->toDateString(), $period->pluck('label')->first());
        $this->assertEquals($end->toDateString(), $period->pluck('label')->last());

        $this->assertSame([
            'name'    => 'Users',
            'labels'  => $period->pluck('label')->toArray(),
            'values'  => $period->pluck('value')->toArray(),
        ], $period->toChart('Users'));
    }

    public function testAvgPeriod(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDays(2);
        $end = (clone $current)->subDay();

        User::factory()->count(5)->create([
            'created_at' => $start,
        ]);

        User::factory()->count(8)->create([
            'created_at' => $end,
        ]);

        $period = User::averageByDays('id', $start, $end);

        $this->assertEquals(3.0, $period->pluck('value')->first());
        $this->assertEquals(9.5, $period->pluck('value')->last());

        $this->assertEquals($start->toDateString(), $period->pluck('label')->first());
        $this->assertEquals($end->toDateString(), $period->pluck('label')->last());

        $this->assertSame([
            'name'    => 'Users',
            'labels'  => $period->pluck('label')->toArray(),
            'values'  => $period->pluck('value')->toArray(),
        ], $period->toChart('Users'));
    }

    public function testPeriodShowDaysOfWeek(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDays(6);

        User::factory()->count(5)->create();

        $period = User::sumByDays('id', $start)->showDaysOfWeek()->toChart('Users');

        collect([
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ])->each(function (string $value) use ($period) {
            $this->assertContains($value, $period['labels']);
        });

        /* Carbon Language */
        Carbon::setLocale('ru');

        $period = User::sumByDays('id', $start)->showDaysOfWeek()->toChart('Users');

        collect([
            'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота',
            'Воскресенье',
        ])->each(function (string $value) use ($period) {
            $this->assertContains($value, $period['labels']);
        });
    }

    public function testPeriodWithoutZero(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDays(2);
        $end = (clone $current)->subDay();

        User::factory()->count(5)->create([
            'created_at' => $start,
        ]);

        User::factory()->count(8)->create([
            'created_at' => $end,
        ]);

        $period = User::countByDays()->withoutZeroValues();

        $this->assertCount(2, $period);

        $this->assertSame([
            'name'    => 'Users',
            'labels'  => $period->pluck('label')->toArray(),
            'values'  => $period->pluck('value')->toArray(),
        ], $period->toChart('Users'));
    }

    protected function tearDown(): void
    {
        Carbon::setLocale('en');

        parent::tearDown();
    }
}
