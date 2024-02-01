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
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\SuscriptorController;
use App\Http\Controllers\NewsletterController;

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
    if (Auth::user() && Auth::user()->es_admin) {
        // Redirige al usuario administrador a la ruta 'admin.index'
        return redirect()->route('admin.index');
    } else {
        // Usa el enrutador para llamar al controlador
        return app()->call('App\Http\Controllers\UsuarioController@showDashboard');
    }
})
->middleware(['auth', 'verified', 'validarUsuario'])
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
    Route::get('/admin/usuarios/export', [UsuarioController::class, 'exportCsv'])->name('admin.usuarios.exportCsv');

    //Horarios
    Route::get('/horarios/index', [HorarioController::class, 'index'])->name('admin.horarios.index');
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('admin.horarios.create');
    Route::post('/horarios/create', [HorarioController::class, 'store'])->name('admin.horarios.store');
    Route::delete('/admin/horarios/{horario}', [HorarioController::class, 'destroy'])->name('admin.horarios.destroy');
    Route::get('/admin/horarios/edit/{id}', [HorarioController::class, 'edit'])->name('admin.horarios.edit');
    Route::put('/admin/horarios/update/{id}', [HorarioController::class, 'update'])->name('admin.horarios.update');

    //Reservas
    Route::get('/reservas/index', [ReservaController::class, 'index'])->name('admin.reservas.index');

    //Valoraciones
    Route::get('/valoraciones/index', [ValoracionController::class, 'index'])->name('admin.valoraciones.index');

    //Newsletter
    Route::get('/admin/newsletters', [NewsletterController::class, 'index'])->name('admin.newsletters.index');
    Route::get('/admin/newsletters/create', [NewsletterController::class, 'create'])->name('admin.newsletters.create');
    Route::post('/admin/newsletters', [NewsletterController::class, 'store'])->name('admin.newsletters.store');
    Route::get('/admin/newsletters/{id}/edit', [NewsletterController::class, 'edit'])->name('admin.newsletters.edit');
    Route::put('/admin/newsletters/{id}', [NewsletterController::class, 'update'])->name('admin.newsletters.update');
    Route::delete('/admin/newsletters/{id}', [NewsletterController::class, 'destroy'])->name('admin.newsletters.destroy');
    Route::post('/admin/newsletters/{id}/select', [NewsletterController::class, 'selectForSending'])->name('admin.newsletters.selectForSending');
    Route::get('/admin/newsletters/deselect/{id}', [NewsletterController::class, 'deselect'])->name('admin.newsletters.deselect');



    Route::get('/admin/newsletters/preview/{id}', [NewsletterController::class, 'preview'])->name('admin.newsletters.preview');
    Route::post('/admin/newsletters/updateConfig', [NewsletterController::class, 'updateConfig'])->name('admin.newsletters.updateConfig');

});

Route::get('/gallery', [GalleryController::class, 'index'])->name('pages.gallery');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('pages.about-us');
Route::get('/form-contact', [FormContactController::class, 'index'])->name('pages.form-contact');

//Catálogo
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('pages.catalogo');
Route::get('/buscar-actividades', [CatalogoController::class, 'buscar'])->name('pages.catalogo.buscar');
Route::get('/catalogo/filter', [CatalogoController::class, 'filter'])->name('catalogo.filter');

// Detalle de la actividad
Route::get('/actividades/{id}', [ActividadController::class, 'detalleActividad'])->name('pages.detalleActividad');

//Politica de cancelacion

Route::get('/politica-cancelacion', function () {
    return view('pages.politica-cancelacion');
});

//Aviso legal

Route::get('/aviso-legal', function () {
    return view('pages.aviso-legal');
});

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

Route::post('/reservas/cancelar-en-lote', [ReservaController::class, 'cancelarEnLote'])->name('reservas.cancelarEnLote');

//Página de contacto
Route::post('/contact', [FormContactController::class, 'submit'])->name('contact.submit');

//Paypal
Route::post('/paypal/checkout/{horarioId}', [PaypalController::class, 'checkout'])->name('paypal.checkout');
Route::get('/paypal/success/{horarioId}', [PaypalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel/{horarioId}', [PaypalController::class, 'cancel'])->name('paypal.cancel');

//Valorar actividad
Route::get('/valorar/{id}', [ValoracionController::class, 'create'])->name('pages.valorar');
// Ruta para almacenar la valoración enviada desde el formulario
Route::post('/valoraciones', [ValoracionController::class, 'store'])->name('valoraciones.store');

Route::get('/valoraciones/editar/{id}', [ValoracionController::class, 'edit'])->name('valoraciones.editar');
Route::put('/valoraciones/actualizar/{id}', [ValoracionController::class, 'update'])->name('valoraciones.actualizar');

Route::delete('/valoraciones/{id}', [ValoracionController::class, 'destroy'])->name('valoraciones.destroy');

//Descarga pdf reserva
Route::get('/descargar-entrada/{reserva_id}', [ReservaController::class, 'descargarEntrada']);

//Newsletter
Route::post('/suscribirse', [SuscriptorController::class, 'store'])->name('suscribirse');
Route::post('/enviar-newsletter', [NewsletterController::class, 'enviarNewsletter'])->name('enviar.newsletter');
Route::get('/cancelar-suscripcion', [SuscriptorController::class, 'cancelarSuscripcion'])->name('cancelar.suscripcion');

require __DIR__ . '/auth.php';
