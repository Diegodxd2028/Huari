<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReciclajeController;
use App\Http\Controllers\RecompensasController;
use App\Http\Controllers\ParticipacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactanosController;
use App\Mail\ContactanosMailable;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CanjeController;
use App\Http\Controllers\AdminController;

// Pantalla previa para elegir tipo de acceso
Route::get('/', function () {
    return view('auth.seleccionar_rol');
})->name('seleccionar-rol');

// Formularios de login separados
Route::get('/login/usuario', [AuthController::class, 'showLoginFormUsuario'])->name('login.form.usuario');
Route::get('/login/admin', [AuthController::class, 'showLoginFormAdmin'])->name('login.form.admin');

// Procesamiento de login
Route::post('/login/usuario', [AuthController::class, 'loginUsuario'])->name('login.submit.usuario');
Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.submit.admin');

// Registro (solo usuarios normales)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Página de inicio después del login (protegida)
Route::get('/inicio', [HomeController::class, 'index'])->middleware('auth')->name('inicio');

// Quiénes somos
Route::get('/quienes-somos', [HomeController::class, 'quienesSomos'])->name('quienes-somos');

// Reciclaje
Route::get('/reciclaje', [ReciclajeController::class, 'index'])->name('reciclaje');

// Recompensas
Route::get('/recompensas', [RecompensasController::class, 'index'])->middleware('auth')->name('recompensas');

// Participación ciudadana
Route::get('/participacion', [ParticipacionController::class, 'index'])->name('participacion');

// Nosotros (página estática)
Route::view('nosotros', 'nosotros')->name('nosotros');

// Contacto
Route::get('contactanos', [ContactanosController::class, 'index'])->name('contactanos.index');
Route::post('contactanos', [ContactanosController::class, 'store'])->name('contactanos.store');

// ✅ NUEVA RUTA para canje de recompensas con CanjesController
Route::post('/canjes', [CanjeController::class, 'store'])->name('canjes.store')->middleware('auth');

// ------------------- RUTAS EXCLUSIVAS PARA ADMIN -------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/mensajes', [AdminController::class, 'mensajes'])->name('mensajes');
    Route::get('/canjes', [AdminController::class, 'canjes'])->name('canjes');
    Route::get('/puntos', [AdminController::class, 'mostrarFormularioPuntos'])->name('puntos');
    Route::post('/puntos', [AdminController::class, 'asignarPuntos'])->name('puntos.asignar');
    // Gestión de recompensas
    Route::get('/recompensas', [RecompensasController::class, 'create'])->name('recompensas.create');
    Route::post('/recompensas', [RecompensasController::class, 'store'])->name('recompensas.store');
});
