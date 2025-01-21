<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layouts\Rows;

class ProfilePasswordLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Password::make('old_password')
                ->placeholder(__('Inserisci la password'))
                ->title(__('Password attuale'))
                ->help('Password impostata al momento'),

            Password::make('password')
                ->placeholder(__('Inserisci la password che va sovrascritta'))
                ->title(__('Nuova password')),

            Password::make('password_confirmation')
                ->placeholder(__('Inserisci la nuova password'))
                ->title(__('Conferma la password'))
                ->help('Una buona password è compresa tra 15 e 8 caratteri, compresi i numeri e le lettere minuscole.'),
        ];
    }
}
