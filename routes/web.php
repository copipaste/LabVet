<?php

use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\ReporteController;
use App\Models\Usuario;
use App\Http\Controllers\OrdenAnalisisController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PdfController;


Route::get('/', function () {
return Inertia::render('Auth/Login', [
        'canResetPassword' => Route::has('password.request'),
        'status' => session('status'),
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para el CRUD de Insumos
    Route::resource('insumos', InsumoController::class);

    // Rutas para el CRUD de Ordenes de Análisis
    Route::resource('ordenesanalisis', OrdenAnalisisController::class);

    // Rutas para el CRUD de Reportes
    Route::resource('pagos', PagoController::class);
});



Route::get('/temas', function () {
    return Inertia::render('ThemeTest');
});

require __DIR__.'/auth.php';


// Route::middleware(['auth', 'verified','role:secretaria'])->group(function () {
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('promociones', PromocionController::class);
    Route::resource('mascotas', PacienteController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('usuarios', UsuarioController::class);


    Route::get('/dashboard', [ReporteController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('reportes.dashboard');


});


// Route::get('p/pdf', [PromocionController::class, 'exportarPDF'])->name('p.pdf');
Route::get('/reportes', [PdfController::class, 'index'])->name('reportes.index');

Route::get('/reportes/generar', [PdfController::class, 'generar'])->name('reportes.generar');
