<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/************* Admin *************/
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Actividades
    Route::get('/actividades/index', [ActividadController::class, 'index'])->name('admin.actividades.index');
    Route::get('/actividades/create', [ActividadController::class, 'create'])->name('admin.actividades.create');
    Route::post('/actividades/create', [ActividadController::class, 'store'])->name('admin.actividades.store');
    Route::get('/actividades/show/{id}', [ActividadController::class, 'show'])->name('admin.actividades.show');
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])->name('admin.actividades.edit');
    Route::put('/actividades/update/{id}', [ActividadController::class, 'update'])->name('admin.actividades.update');
    Route::delete('/actividades/{actividad}/delete', [ActividadController::class, 'destroy'])->name('admin.actividades.delete');

    // Usuarios
    Route::get('/usuarios/index', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
    Route::put('/usuarios/{usuario}/validar', [UsuarioController::class, 'validar'])->name('admin.usuarios.validar');


});

require __DIR__ . '/auth.php';
