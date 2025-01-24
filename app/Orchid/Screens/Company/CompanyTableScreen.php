<?php

namespace App\Orchid\Screens\Company;

use App\Models\Company;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CompanyTableScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'companies' => Company::with('type')->orderby('id', 'desc')->get()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Aziende';
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
                ->route('platform.company.create')
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

            Layout::table('companies', [
                TD::make('id', 'ID'),
                //TD::make('logo', 'Logo'),
                TD::make('name', 'Nome'),
                TD::make('VAT', 'IVA'),
                TD::make('type.name', 'Tipologia'),
                TD::make('azioni')
                    ->width('100px')
                    ->render(fn(Company $company) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make('Visualizza')
                        ->icon('bs.eye'),

                        Link::make(__('Modifica'))
                        //->route('platform.company.create', $company->id)
                        ->icon('bs.pencil'),

                        Button::make(__('Cancella'))
                        ->icon('bs.trash3')
                        ->confirm(__('Una volta cancellato l\' azienda, non sarà possibile recuperarla. Sei sicuro di volerla eliminare ?'))
                        ->method('remove', [
                            'id' => $company->id,
                        ]),
                    ])),
            ])
        ];
    }

    /**
     * Remove the specified company from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id): \Illuminate\Http\RedirectResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();

        Toast::info(__('Azienda eliminata con successo.'));

        return redirect()->route('platform.company.table');
    }
}
