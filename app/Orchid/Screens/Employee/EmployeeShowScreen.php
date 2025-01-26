<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

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
            ->route('platform.employee.edit', $this->employee->id)
            ->icon('bs.pencil')
            ->class('btn p-2 rounded-1'),

            Button::make()
            ->icon('bs.trash3')
            ->class('btn p-2 rounded-1 text-danger')
            ->confirm(__('Una volta cancellato il dipendente, non sarà possibile recuperarlo. Sei sicuro di eliminarlo?.'))
            ->method('remove', [
                'id' => $this->employee->id,
            ])
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
                    ->title('Nome:')
                    ->horizontal()
                    ->value($this->employee->name),

                Label::make('Cognome')
                    ->title('Cognome:')
                    ->horizontal()
                    ->value($this->employee->lastname),

                Label::make('Azienda')
                    ->title('Azienda:')
                    ->horizontal()
                    ->value(Link::make($this->employee->company->name)
                                ->class('badge bg-info text-light p-2')
                                ->route('platform.company.show', $this->employee->company->id)
                            ),

                Label::make('Aggiunto il')
                    ->title('Aggiunto il:')
                    ->horizontal()
                    ->value($this->employee->created_at),

                Label::make('Ultima modifica:')
                    ->title('Ultima modifica:')
                    ->horizontal()
                    ->value($this->employee->updated_at),

            ])->title('Informazioni generali'),

            Layout::rows([

                Label::make('Email')
                ->title('Email:')
                ->horizontal()
                ->value($this->employee->email),

                Label::make('Telefono')
                ->title('Telefono:')
                ->horizontal()
                ->value($this->employee->phone_number),

            ])->title('Recapiti')
        ];


    }

    /**
     * Rimuovi il dipendente dal database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id): \Illuminate\Http\RedirectResponse
    {
        $employee = Employee::findOrFail($id);

        if ($employee->delete()) {
            Toast::info(__('Dipendente eliminato con successo.'));
        } else {
            Toast::danger(__('Errore nella procedura'));
        }

        return redirect()->route('platform.employee.table');
    }
}
