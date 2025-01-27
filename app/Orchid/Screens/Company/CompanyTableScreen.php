<?php

namespace App\Orchid\Screens\Company;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;
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
            'companies' => Company::filters()->with('type')->orderby('id', 'desc')
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
            Layout::table('companies', [
                TD::make('id', 'ID')->sort(),
                TD::make('logo', 'Logo')
                ->render(function (Company $company) {
                    $logoPath = $company->logo;

                    if (strpos($logoPath, 'storage/') === false) {
                        $logoPath = 'storage/' . $logoPath;
                    }

                    return $logoPath
                    ? "<img src='" . asset($logoPath) . "' alt='Logo' style='width: 50px; height: 50px; object-fit: cover; border-radius: 100%;'>"
                    : '<span>Nessun logo</span>';
                }),
                TD::make('name', 'Nome')->sort(),
                TD::make('type.name', 'Settore'),
                TD::make('azioni')
                    ->width('100px')
                    ->render(fn(Company $company) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make('Visualizza')
                        ->route('platform.company.show', $company->id)
                        ->icon('bs.eye'),

                        Link::make(__('Modifica'))
                        ->route('platform.company.edit', $company->id)
                        ->icon('bs.pencil'),

                        Button::make(__('Cancella'))
                        ->icon('bs.trash3')
                        ->confirm(__('Una volta cancellata l\' azienda, non sarà possibile recuperarla. Sei sicuro di volerla eliminare ?'))
                        ->method('remove', [
                            'id' => $company->id,
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
        $company = Company::findOrFail($id);
        $company->delete();

        Toast::info(__('Azienda eliminata con successo.'));

        return redirect()->route('platform.company.table');
    }

    /**
     * @return string
     */
    protected function iconNotFound(): string
    {
        return 'table';
    }

    /**
     * @return string
     */
    protected function textNotFound(): string
    {
        return __('Non ci sono risorse da mostrare');
    }

    /**
     * @return string
     */
    protected function subNotFound(): string
    {
        return '';
    }
}
