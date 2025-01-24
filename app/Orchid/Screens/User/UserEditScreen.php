<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\Orchid\Layouts\User\UserRoleLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use App\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserEditScreen extends Screen
{
    /**
     * @var User
     */
    public $user;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user): iterable
    {
        $user->load(['roles']);

        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->user->exists ? 'Modifica utente' : 'Crea nuovo utente';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Inserisci le tue informazioni personali per creare un nuovo profilo';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Sostituisci'))
                ->icon('bg.box-arrow-in-right')
                ->confirm(__('Puoi ritornare al tuo profilo originale disconnettendoti'))
                ->method('loginAs')
                ->canSee($this->user->exists && $this->user->id !== \request()->user()->id),

            Button::make(__('Cancella'))
                ->icon('bs.trash3')
                ->confirm(__('Una volta cancellato, il profilo non sarà più disponibile. Sei sicuro di voler procedere?'))
                ->method('remove')
                ->canSee($this->user->exists),

            Button::make(__('Salva'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(UserEditLayout::class)
                ->title(__('Informazioni profilo'))
                ->description(__('Inserisci le informazioni sul tuo profilo e la tua email.'))
                ->commands(
                    Button::make(__('Salva'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(UserPasswordLayout::class)
                ->title(__('Password'))
                ->description(__('Assicurati che la tua password sia sufficientemente lunga e impossibile da decifrare'))
                ->commands(
                    Button::make(__('Salva'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            // Layout::block(UserRoleLayout::class)
                // ->title(__('Roles'))
                // ->description(__('A Role defines a set of tasks a user assigned the role is allowed to perform.'))
                // ->commands(
                    // Button::make(__('Save'))
                        // ->type(Color::BASIC)
                        // ->icon('bs.check-circle')
                        // ->canSee($this->user->exists)
                        // ->method('save')
                // ),

            // Layout::block(RolePermissionLayout::class)
                // ->title(__('Permissions'))
                // ->description(__('Allow the user to perform some actions that are not provided for by his roles'))
                // ->commands(
                    // Button::make(__('Save'))
                        // ->type(Color::BASIC)
                        // ->icon('bs.check-circle')
                        // ->canSee($this->user->exists)
                        // ->method('save')
                // ),

        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, Request $request)
    {
        $request->validate([
            'user.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
        ]);

        $permissions = collect($request->get('permissions'))
            ->map(fn ($value, $key) => [base64_decode($key) => $value])
            ->collapse()
            ->toArray();

        $user->when($request->filled('user.password'), function (Builder $builder) use ($request) {
            $builder->getModel()->password = Hash::make($request->input('user.password'));
        });

        $user
            ->fill($request->collect('user')->except(['password', 'permissions', 'roles'])->toArray())
            ->forceFill(['permissions' => $permissions])
            ->save();

        $user->replaceRoles($request->input('user.roles'));

        Toast::info(__('Utente salvato.'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();

        Toast::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        Impersonation::loginAs($user);

        Toast::info(__('You are now impersonating this user'));

        return redirect()->route(config('platform.index'));
    }
}
