<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; // Aun no implementada
use App\Http\Controllers\VisualizerController;
use App\Http\Controllers\ScreenshotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Visualizador de audio (disponible para todos los usuarios autenticados)
    Route::get('/visualizer', [VisualizerController::class, 'index'])->name('visualizer.index');

    // Captura y envío de screenshot
    Route::post('/screenshot/capture', [ScreenshotController::class, 'capture'])->name('screenshot.capture');
    Route::get('/screenshots', [ScreenshotController::class, 'index'])->name('screenshots.index');
});

// Rutas de administración (solo admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class); // Falta por crear
});

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
