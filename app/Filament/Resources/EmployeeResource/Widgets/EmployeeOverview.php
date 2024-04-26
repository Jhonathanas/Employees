<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Country;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $indonesianCount = Employee::where('country_id', '2')->count();
        $nonIndonesianCount = Employee::where('country_id', '!=', '2')->count();

        return [
            Stat::make('All Employees', Employee::count()),
            Stat::make('Indonesian', $indonesianCount),
            Stat::make('Non-Indonesian', $nonIndonesianCount),
        ];
    }
}
