<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipientController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::get('/documents/owned', [DocumentController::class, 'owned'])->name('document.owned');
    Route::get('/documents/shared', [DocumentController::class, 'shared'])->name('document.shared');
    Route::get('/documents/trash', [DocumentController::class, 'trash'])->name('document.trash');
    Route::post('/documents', [DocumentController::class, 'store'])->name('document.store');
    Route::delete('/documents/{id}', [DocumentController::class, 'softDestroy'])->name('document.softDestroy');
    Route::delete('/documents/{id}/permanent', [DocumentController::class, 'permanentDestroy'])->name('document.permanentDestroy');
    Route::get('/documents/{id}', [DocumentController::class, 'restore'])->name('document.restore');
    Route::post('/documents/share', [DocumentController::class, 'share'])->name('document.share');
    Route::get('/recipients/search/{search}', [RecipientController::class, 'search'])->name('recipient.search');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
