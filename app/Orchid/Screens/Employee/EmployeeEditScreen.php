<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Company;
use App\Models\Employee;
use Orchid\Icons\Icon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeEditScreen extends Screen
{
    public $employee;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Employee $employee): iterable
    {
        return [
            'employee' => $employee
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Modifica di ' . $this->employee->name . ' ' . $this->employee->lastname;
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
                ->route('platform.employee.table')
                ->class('btn gap-2 rounded-1')
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

                Input::make('employee.name')
                    ->title('Nome')
                    ->value($this->employee->name)
                    ->horizontal()
                    ->required(),

                Input::make('employee.lastname')
                    ->title('Cognome')
                    ->value($this->employee->lastname)
                    ->horizontal()
                    ->required(),

                Select::make('employee.company_id')
                    ->title('Azienda')
                    ->options(
                        Company::pluck('name', 'id')->toArray()
                    )
                    ->value($this->employee->company_id)
                    ->horizontal()
                    ->required(),

                Input::make('employee.email')
                    ->title('Email')
                    ->value($this->employee->email)
                    ->horizontal()
                    ->required(),

                Input::make('employee.phone_number')
                    ->title('Telefono')
                    ->value($this->employee->phone_number)
                    ->horizontal()
                    ->required(),

                Button::make('Aggiorna')
                    ->method('updateEmployee')
                    ->icon('bs.check-circle')
                    ->class('btn btn-primary gap-2'),
            ]),
        ];
    }

    public function updateEmployee()
    {
        $this->employee->update(request()->get('employee'));

        Toast::info('Dipendente aggiornato con successo!');

        return redirect()->route('platform.employee.show', $this->employee->id);
    }
}
