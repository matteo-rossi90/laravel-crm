<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeFormScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Aggiungi un nuovo dipendente';
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
            ->route('platform.company.table')
            ->class('btn gap-2 align-items-center rounded-1')
            ->icon('bs.arrow-left-circle')
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
                Group::make([
                    Input::make('employee.name')
                        ->title('Nome')
                        ->placeholder('Inserisci il nome')
                        ->required(),

                    Input::make('employee.lastname')
                        ->title('Cognome')
                        ->placeholder('Inserisci cognome')
                        ->required(),

                ]),

                Group::make([

                    Input::make('employee.phone_number')
                        ->title('Telefono')
                        ->type('tel')
                        ->placeholder('Inserisci numero di telefono')
                        ->required(),

                    Select::make('employee.company')
                        ->title('Azienda')
                        ->fromModel(Company::class, 'companies.name')
                        ->empty('Seleziona l\'azienda di riferimento')
                        ->required()
                ]),

                Input::make('employee.email')
                    ->type('email')
                    ->title('Email')
                    ->placeholder('Inserisci email')
                    ->required(),


                Button::make('Aggiungi')
                    ->method('saveEmployee')
                    ->icon('bs.check-circle')
                    ->class('btn btn-primary gap-2'),

            ])->title('Informazioni')

        ];
    }

    public function saveEmployee(): RedirectResponse
    {
        $data = request()->validate([
            'employee.name' => 'required|string|max:50',
            'employee.lastname' => 'required|string|max:50',
            'employee.phone_number' => 'nullable|string|max:20',
            'employee.email' => 'required|string|email|max:50|unique:employees,email',
            'employee.company' => 'required|exists:companies,id',

        ]);
        // $this->messages();
        Employee::create([
            'name' => $data['employee']['name'],
            'lastname' => $data['employee']['lastname'],
            'email' => $data['employee']['email'],
            'phone_number' => $data['employee']['phone_number'],
            'company_id' => $data['employee']['company'],
        ]);
        Toast::info('Dipendente creato con successo!');
        return redirect()->route('platform.employee.table');
    }
}
