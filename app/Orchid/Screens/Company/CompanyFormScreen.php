<?php

namespace App\Orchid\Screens\Company;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CompanyFormScreen extends Screen
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
        return 'Aggiungi una nuova azienda';
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
                        Input::make('company.name')
                            ->title('Nome')
                            ->placeholder('Inserisci il nome')
                            ->required(),

                        Input::make('company.VAT')
                            ->title('Partita IVA')
                            ->placeholder('Inserisci partita IVA')
                            ->required(),

                     ]),

            Group::make([

                    Input::make('company.address')
                        ->title('Indirizzo')
                        ->placeholder('Inserisci indirizzo'),

                    Select::make('company.type_id')
                        ->title('Settore')
                        ->fromModel(Type::class, 'types.name')
                        ->empty('Seleziona il settore di riferimento')
                        ->required()
            ]),


                // Attach::make('company.logo')
                // ->title('Carica logo azienale')
                // ->accept('image/*')
                // ->popover('Seleziona un\'immagine che sia in formato png, jpg o jpeg')
                // ->maxFiles(1),

                Cropper::make('company.logo')
                    ->title('Carica logo aziendale')
                    ->targetRelativeUrl()
                    ->storage('public')
                    ->width(100)
                    ->height(100)
                    ->path('img')
                    ->maxFileSize(2)
                    ->acceptedTypes(['image/jpeg', 'image/png', 'image/jpg'])
                    ->horizontal(),


                SimpleMDE::make('company.description')
                    ->title('Descrizione')
                    ->popover('Descrivi l\'azienda che vuoi inserire'),

                Button::make('Aggiungi')
                    ->method('saveCompany')
                    ->icon('bs.check-circle')
                    ->class('btn btn-primary gap-2 rounded-1'),

                ])->title('Informazioni')
        ];
    }

    public function saveCompany(CompanyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // if (request()->hasFile('company.logo')) {
        // $image = request()->file('company.logo');
        // $path = $image->store('img', 'public');
        // $company->logo = $path;
        // $company->save();
        // }

        // if (array_key_exists('logo', $data)) {
        // $image = Storage::put('img', $data['logo']);
        // $data['logo'] = $image;
        // }

        if (request()->hasFile('company.logo')) {
            $image = request()->file('company.logo');
            $path = $image->store('img', 'public');
            $data['company']['logo'] = $path;
        }

        $company = Company::create([
            'name' => $data['company']['name'],
            'VAT' => $data['company']['VAT'],
            'address' => $data['company']['address'] ?? null,
            'type_id' => $data['company']['type_id'],
            'logo' => $data['company']['logo'],
            'description' => $data['company']['description'] ?? null,
        ]);

        if($company){
            Toast::info('Azienda creata con successo!');
        }else{
            Toast::warning('Errore nella procedura');
        }
        return redirect()->route('platform.company.table');
    }

}
