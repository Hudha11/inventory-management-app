<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/items', action: \App\Livewire\Items\ItemIndex::class)->name(name: 'items.index');
    Route::get('/items/create', action: \App\Livewire\Items\ItemCreate::class)->name(name: 'items.create');
    // Route::post('/items', [App\Http\Controllers\ItemController::class, 'store'])->name('items.store');
    // Route::get('/items/{item}', [App\Http\Controllers\ItemController::class, 'show'])->name('items.show');
    Route::get('/items/{item}/edit', action: \App\Livewire\Items\ItemEdit::class)->name(name: 'items.edit');
    // Route::put('/items/{item}', [App\Http\Controllers\ItemController::class, 'update'])->name('items.update');
    // Route::delete('/items/{item}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('items.destroy');
});

// require __DIR__ . '/auth.php';
