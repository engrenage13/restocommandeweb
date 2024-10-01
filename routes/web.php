<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
  return Inertia::render('Home');
})->name('home');

Route::middleware('auth')->group(function () {
  Route::get('profil', [ProfileController::class, 'show'])->name('profile.show');
  Route::get('/modif-profil', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/modif-profil', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/modif-profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
