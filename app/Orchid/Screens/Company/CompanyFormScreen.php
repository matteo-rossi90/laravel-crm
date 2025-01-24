<?php

namespace App\Orchid\Screens\Company;

use App\Models\Company;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
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
                ->class('btn gap-2 align-items-center')
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
                        ->placeholder('Inserisci indirizzo')
                        ->required(),

                    Select::make('company.type')
                        ->title('Settore')
                        ->fromModel(Type::class, 'types.name')
                        ->empty('Seleziona il settore di riferimento')
                        ->required()
            ]),


                Cropper::make('company.logo')
                ->title('Logo aziendale')
                ->width(100)
                ->height(100),

                SimpleMDE::make('company.description')
                ->title('Descrizione')
                ->popover('Descrivi l\'azienda che vuoi inserire'),

                Button::make('Aggiungi')
                ->method('saveCompany')
                ->icon('bs.check-circle')
                ->class('btn btn-primary gap-2'),

                ])->title('Informazioni')
        ];
    }

    public function saveCompany(): RedirectResponse
    {
        $data = request()->validate([
            'company.name' => 'required|string|max:50',
            'company.VAT' => 'required|string|max:11',
            'company.address' => 'nullable|string|max:255',
            'company.type' => 'required|exists:types,id',
            'company.logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'company.description' => 'nullable|string',
        ]);
        $this->messages();

        Company::create([
            'name' => $data['company']['name'],
            'VAT' => $data['company']['VAT'],
            'address' => $data['company']['address'] ?? null,
            'type_id' => $data['company']['type'],
            'logo' => $data['company']['logo'] ?? null,
            'description' => $data['company']['description'] ?? null,
        ]);
        Toast::info('Azienda creata con successo!');
        return redirect()->route('platform.company.table');
    }

    private function messages(){
        return[
            'company.name.required' => 'Il campo Nome è obbligatorio.',
            'company.name.max' => 'Il campo Nome non può superare i 50 caratteri.',
            'company.VAT.required' => 'Il campo Partita IVA è obbligatorio.',
            'company.VAT.max' => 'La Partita IVA deve essere lunga al massimo 11 caratteri.',
            'company.type.required' => 'Il campo Settore è obbligatorio.',
            'company.type.exists' => 'Il settore selezionato non è valido.',
            'company.logo.image' => 'Il logo deve essere un file immagine.',
            'company.logo.mimes' => 'Il logo deve essere un file di tipo: png, jpg o jpeg.',
            'company.logo.max' => 'Il logo non può superare i 2MB.',
            'company.description.string' => 'La descrizione deve essere un testo valido.',
        ];

    }

    private function getError($field)
    {
        $errors = Session::get('errors');
        return $errors?->get($field)[0] ?? null;

    }

}
