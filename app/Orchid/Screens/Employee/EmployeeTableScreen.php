<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

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
            'employees' => Employee::with('company')->orderby('id', 'desc' )
            ->paginate(10)
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
            ->route('platform.employee.create')
            ->icon('bs.plus-circle')
            ->class('btn btn-primary gap-2 rounded-1')
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
                TD::make('id', 'ID')->sort(),
                TD::make('name', 'Nome')->sort(),
                TD::make('lastname', 'Cognome')->sort(),
                TD::make('company.name', 'Azienda')->sort(),
                TD::make('azioni')
                    ->width('100px')
                    ->render(fn(Employee $employee) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make('Visualizza')
                        ->route('platform.employee.show', $employee->id)
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

    /**
     * Remove the specified employee from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id): \Illuminate\Http\RedirectResponse
    {
        $employee = Employee::findOrFail($id);
        if($employee->delete()){
            Toast::info(__('Dipendente eliminato con successo.'));
        }else{
            Toast::danger(__('Errore nella procedura'));
        }

        return redirect()->route('platform.employee.table');
    }
}
