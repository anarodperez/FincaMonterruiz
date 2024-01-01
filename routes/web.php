<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\FormContactController;
use App\Http\Controllers\PaypalController;

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

// Vista inicial cuando arrancas la app.
Route::get('/', [IndexController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    if (Auth::user()->es_admin) {
        return redirect()->route('admin.index');
    }
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
    Route::get('/actividades/show/{actividad}', [ActividadController::class, 'show'])->name('admin.actividades.show');
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])->name('admin.actividades.edit');
    Route::put('/actividades/update/{id}', [ActividadController::class, 'update'])->name('admin.actividades.update');
    Route::delete('/actividades/{actividad}/delete', [ActividadController::class, 'destroy'])->name('admin.actividades.delete');

    // Usuarios
    Route::get('/usuarios/index', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
    Route::put('/usuarios/{usuario}/validar', [UsuarioController::class, 'validar'])->name('admin.usuarios.validar');

    //Horarios
    Route::get('/horarios/index', [HorarioController::class, 'index'])->name('admin.horarios.index');
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('admin.horarios.create');
    Route::post('/horarios/create', [HorarioController::class, 'store'])->name('admin.horarios.store');
    Route::delete('/admin/horarios/{horario}', [HorarioController::class, 'destroy'])->name('admin.horarios.destroy');
    Route::get('/admin/horarios/edit/{id}', [HorarioController::class, 'edit'])->name('admin.horarios.edit');
    Route::put('/admin/horarios/update/{id}', [HorarioController::class, 'update'])->name('admin.horarios.update');

    //Reservas
    Route::get('/reservas/index', [ReservaController::class, 'index'])->name('admin.reservas.index');

});

Route::get('/login/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/login/google/callback', function () {
    $user = Socialite::driver('google')->user();

    // Verifica si el usuario existe en la base de datos
    $existingUser = User::where('email', $user->getEmail())->first();

    if ($existingUser) {
        // Si el usuario existe, inicia sesión
        Auth::login($existingUser);
    } else {
        // Si el usuario no existe, crea un nuevo usuario y luego inicia sesión
        $newUser = new User();
        $newUser->name = $user->getName();
        $newUser->email = $user->getEmail();
        $newUser->save();

        Auth::login($newUser);
    }

    return redirect()->route('index'); // Redirige al usuario a la vista de bienvenida
});

Route::get('admin/usuarios/autocomplete', [UsuarioController::class, 'autocomplete'])->name('admin.usuarios.autocomplete');

Route::get('/gallery', [GalleryController::class, 'index'])->name('pages.gallery');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('pages.about-us');
Route::get('/form-contact', [FormContactController::class, 'index'])->name('pages.form-contact');

//Catálogo
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('pages.catalogo');
Route::get('/buscar-actividades', [CatalogoController::class, 'buscar'])->name('pages.catalogo.buscar');
Route::get('/catalogo/filter', [CatalogoController::class, 'filter'])->name('catalogo.filter');

// Detalle de la actividad
Route::get('/actividades/{id}', [ActividadController::class, 'detalleActividad'])->name('pages.detalleActividad');

// Mostrar la página de reserva (requiere autenticación)
Route::get('/reservar/{horarioId}', [ReservaController::class, 'show'])
    ->middleware('auth')
    ->name('reservar.show');

// Almacenar los datos de la reserva en la sesión
Route::post('/session/set', function (Request $request) {
    session(['reserva_fecha' => $request->fecha, 'reserva_hora' => $request->hora]);
    return response()->json(['message' => 'Session updated']);
});

// Procesar y almacenar la reserva
Route::post('/reservar/store', [ReservaController::class, 'store'])->name('reservar.store');

//Cancelar reserva
Route::post('/reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');


Route::get('/dashboard', [UsuarioController::class, 'showDashboard'])->name('dashboard');

// Carga de contenido dinámico para las secciones del dashboard
Route::get('/dashboard/cargar-reservas', [UsuarioController::class, 'cargarReservas'])->name('dashboard.cargarReservas');
Route::get('/dashboard/cargar-valoraciones', [UsuarioController::class, 'cargarValoraciones'])->name('dashboard.cargarValoraciones');


Route::post('/contact', [FormContactController::class, 'submit'])->name('contact.submit');


//Paypal
Route::post('/paypal/checkout/{horarioId}', [PaypalController::class, 'checkout'])->name('paypal.checkout');
Route::get('/paypal/success/{horarioId}', [PaypalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel/{horarioId}', [PaypalController::class, 'cancel'])->name('paypal.cancel');



require __DIR__ . '/auth.php';
