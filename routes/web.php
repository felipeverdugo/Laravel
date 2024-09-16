<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Livewire\MisAplicacionesComponent;
use App\Http\Livewire\AplicacionesEnfermeroComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::impersonate();
Route::get('/', fn() => redirect('dashboard'));
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


$lumkiPrefix = config('lumki.prefix') ?? "lumki";
$lumkiMiddleware = config('lumki.middleware') ?? ["auth:sanctum",'web','can:manage users', 'forbid.blocked'];

Route::prefix($lumkiPrefix)
    // ->namespace("Kineticamobile\Lumki\Controllers")
    ->as('lumki.')
    ->middleware($lumkiMiddleware)
    ->group(function () {

    // USERS
    Route::resource('users', UserController::class);
    // ROLES
    // Route::resource('roles', RoleController::class);
    // PERMISSIONS
    // Route::resource('permissions', PermissionController::class);

});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::post('/users/block/{user}', [ UserController::class, 'block' ])->name('users.block');
    Route::get('/aplicaciones', MisAplicacionesComponent::class)->name('aplicaciones');
    Route::get('/vacunatorio', AplicacionesEnfermeroComponent::class)->name('aplicacionesEnfermero');
    // Route::get('/user',[ UserController::class, 'index' ])->name('userData');
});

