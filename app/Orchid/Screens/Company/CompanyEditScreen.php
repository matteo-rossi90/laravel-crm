<?php

namespace App\Orchid\Screens\Company;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Type;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CompanyEditScreen extends Screen
{
    public $company;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Company $company): iterable
    {
        return [
            'company' => $company
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Modifica di ' . $this->company->name;
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
            ->route('platform.company.table')
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

                Input::make('company.name')
                    ->title('Nome')
                    ->value($this->company->name)
                    ->horizontal()
                    ->required(),

                Input::make('company.VAT')
                    ->title('Partita IVA')
                    ->value($this->company->VAT)
                    ->horizontal()
                    ->required(),

                Select::make('company.type_id')
                    ->title('Azienda')
                    ->options(
                        Type::pluck('name', 'id')->toArray()
                    )
                    ->value($this->company->type_id)
                    ->empty('Nessuno')
                    ->horizontal()
                    ->required(),

                Input::make('company.address')
                    ->title('Indirizzo')
                    ->value($this->company->address)
                    ->horizontal(),

                Cropper::make('company.logo')
                        ->title('Carica logo aziendale')
                        ->targetRelativeUrl()
                        ->value($this->company->logo)
                        ->storage('public')
                        ->path('img')
                            ->maxFileSize(2)
                            ->acceptedTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->horizontal(),

                SimpleMDE::make('company.description')
                    ->title('Descrizione')
                    ->popover('Descrivi l\'azienda che vuoi inserire')
                    ->value($this->company->description),

                Button::make('Aggiorna')
                    ->method('updateCompany')
                    ->icon('bs.check-circle')
                    ->class('btn btn-primary gap-2'),
            ]),
        ];
    }

    public function updateCompany(CompanyRequest $request)
    {
        $data = $request->validated();

        $this->company->update($data['company']);

        // $this->company->update(request()->get('company'));
        Toast::info('Azienda aggiornata con successo!');
        return redirect()->route('platform.company.show', $this->company->id);
    }
}
