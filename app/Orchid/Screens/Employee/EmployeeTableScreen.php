<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class EmployeeTableScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'employees' => Employee::with('company')->orderby('id', 'desc' )->get()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Dipendenti';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Nuovo')
            ->icon('bs.plus-circle')
            ->class('btn btn-primary gap-2')
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

            Layout::table('employees', [
                TD::make('id', 'ID'),
                TD::make('name', 'Nome'),
                TD::make('lastname', 'Cognome'),
                TD::make('company.name', 'Azienda'),
                TD::make('email', 'Email'),
                TD::make('phone_number', 'Telefono'),
                TD::make('azioni')
                    ->width('100px')
                    ->render(fn(Employee $employee) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make('Visualizza')
                        ->icon('bs.eye'),

                        Link::make(__('Modifica'))
                        //->route('platform.systems.users.edit', $employee->id)
                        ->icon('bs.pencil'),

                        Button::make(__('Cancella'))
                        ->icon('bs.trash3')
                        ->confirm(__('Una volta cancellato il dipendente, non sarà possibile recuperarlo. Sei sicuro di eliminarlo?.'))
                        ->method('remove', [
                            'id' => $employee->id,
                        ]),
                    ])),
            ])
        ];
    }
}
