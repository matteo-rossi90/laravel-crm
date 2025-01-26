<?php

namespace App\Orchid\Screens\Statistics;

use App\Models\Company;
use App\Models\Employee;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts\Layout;
use Orchid\Support\Facades\Layout as LayoutFacade;

class StatisticsShowScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $totalEmployees = Employee::count();

        $totalCompanies = Company::count();

        $lastCompany = Company::latest()->first();

        return [
            'totalEmployees' => $totalEmployees,
            'totalCompanies' => $totalCompanies,
            'lastCompany' => $lastCompany
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Statistiche';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Indietro')
                ->icon('bs.arrow-left-circle')
                ->class('btn gap-2 rounded-1')
                ->route('platform.main')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {


        return [

            LayoutFacade::view('platform::statistics.statistics', [
                'totalEmployees' => ['totalEmployees'],
                'totalCompanies' => ['totalCompanies'],
                'lastCompany' => ['lastCompany']
            ]),

        ];
    }
}
