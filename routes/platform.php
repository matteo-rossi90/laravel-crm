<?php

declare(strict_types=1);

use App\Models\Company;
use App\Orchid\Screens\Company\CompanyEditScreen;
use App\Orchid\Screens\Company\CompanyFormScreen;
use App\Orchid\Screens\Company\CompanyShowScreen;
use App\Orchid\Screens\Company\CompanyTableScreen;
use App\Orchid\Screens\Employee\EmployeeEditScreen;
use App\Orchid\Screens\Employee\EmployeeFormScreen;
use App\Orchid\Screens\Employee\EmployeeShowScreen;
use App\Orchid\Screens\Employee\EmployeeTableScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profilo'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Nuovo'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Utenti'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Generale'));

// Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
// Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
// Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
// Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

//Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
//Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
//Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
// Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

// Route::screen('idea', Idea::class, 'platform.screens.idea');

Route::screen('/aziende', CompanyTableScreen::class)->name('platform.company.table');
Route::screen('/azienda/{company}', CompanyShowScreen::class)->name('platform.company.show');
Route::screen('/azienda/{company}/modifica', CompanyEditScreen::class)->name('platform.company.edit')->middleware('web');
Route::screen('/aziende/aggiungi', CompanyFormScreen::class)->name('platform.company.create');

Route::screen('/dipendenti', EmployeeTableScreen::class)->name('platform.employee.table');

Route::screen('/dipendenti/aggiungi', EmployeeFormScreen::class)->name('platform.employee.create');
Route::screen('/dipendenti/{employee}', EmployeeShowScreen::class)->name('platform.employee.show');
Route::screen('/dipendenti/{employee}/modifica', EmployeeEditScreen::class)->name('platform.employee.edit');

