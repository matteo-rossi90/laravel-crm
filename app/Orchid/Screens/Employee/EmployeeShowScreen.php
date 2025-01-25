<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class EmployeeShowScreen extends Screen
{
    public $employee;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Employee $employee): iterable
    {
        $this->employee = $employee;

        return [
            'employee' => $employee,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Informazioni di ' . $this->employee->name . ' ' . $this->employee->lastname;
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
            ->route('platform.employee.table')
            ->icon('bs.arrow-left-circle')
            ->class('btn gap-2 rounded-1'),

            Link::make()
            //->route('platform.employee.edit, $employee->id')
            ->icon('bs.pencil')
            ->class('btn p-2 rounded-1'),

            Button::make()
            ->icon('bs.trash3')
            ->class('btn p-2 rounded-1 text-danger')
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
            Layout::rows([
                Label::make('Nome')
                    ->title('Nome')
                    ->horizontal()
                    ->value($this->employee->name),

                Label::make('Cognome')
                    ->title('Cognome')
                    ->horizontal()
                    ->value($this->employee->lastname),

                Label::make('Email')
                    ->title('Email')
                    ->horizontal()
                    ->value($this->employee->email),

                Label::make('Azienda')
                    ->title('Azienda')
                    ->horizontal()
                    ->value($this->employee->company->name),

            ]),
        ];
    }
}
