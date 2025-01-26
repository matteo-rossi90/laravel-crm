<?php

namespace App\Orchid\Screens\Company;

use App\Models\Company;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CompanyShowScreen extends Screen
{
    public $company;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Company $company): iterable
    {
        $this->company = $company;
        $employees = $company->employees()
                        ->orderBy('id', 'desc')
                        ->get();
        return [
            'company' => $company,
            'employees' => $company->employees->sortBy('id')
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Azienda ' . $this->company->name;
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
                ->route('platform.company.edit', $this->company->id)
                ->icon('bs.pencil')
                ->class('btn p-2 rounded-1'),

            Button::make()
            ->icon('bs.trash3')
            ->class('btn p-2 rounded-1 text-danger')
            ->confirm(__('Una volta cancellata l\'azienda, non sarà possibile recuperarla. Sei sicuro di eliminarla?.'))
            ->method('remove', [
                'id' => $this->company->id,
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
        // $logoPath = $this->company->logo;
        // if ($logoPath && strpos($logoPath, 'storage/') === false) {
        // $logoPath = 'storage/' . $logoPath;
        //  }

        $logoPath = $this->company->logo;

        if ($logoPath && strpos($logoPath, 'storage/') === false) {
            $logoPath = 'storage/' . $logoPath;
        }

        return [


            Layout::columns([

                Layout::view('platform::images\logo', [
                    'logo' => $logoPath ?: 'images/default-logo.png',
                ]),

                Layout::rows([

                    Label::make('Nome')
                        ->title('Nome')
                        ->value($this->company->name)
                        ->horizontal(),

                    Label::make('Partita IVA')
                        ->title('Partita IVA')
                        ->value($this->company->VAT)
                        ->horizontal(),

                    Label::make('Settore')
                        ->title('Settore')
                        ->value($this->company->type ? $this->company->type->name : 'Nessun settore disponibile')
                        ->horizontal(),

                    Label::make('Descrizione')
                    ->title('Descrizione')
                    ->value($this->company->description ? $this->company->description : 'Nessuna descrizione disponibile')
                    ->horizontal(),

                    Label::make('Indirizzo')
                    ->title('Indirizzo')
                    ->value($this->company->address)
                    ->horizontal()
                ])->title('Informazioni generali'),

            ]),

            Layout::table('employees', [
                TD::make('id', 'ID'),
                TD::make('name', 'Nome'),
                TD::make('email', 'Email'),
                TD::make('created_at', 'Aggiunto il'),
                TD::make('Azioni')
                ->render(function ($employee) {
                    return Link::make()
                        ->route('platform.employee.show', $employee->id)
                        ->icon('bs.eye');
                })
            ])->title('Dipendenti')





        ];
    }

    /**
     * Rimuovi l'azienda dal database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id): \Illuminate\Http\RedirectResponse
    {
        $company = Company::findOrFail($id);
        if ($company->delete()) {
            Toast::info(__('Azienda eliminata con successo.'));
        } else {
            Toast::danger(__('Errore nella procedura'));
        }
        return redirect()->route('platform.company.table');
    }
}
