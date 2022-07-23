<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', static function () {
    return view('home');
})->name('main');

Route::get('/old', static function () {
    return view('old-home');
})->name('main-old');

Route::post('language/{locale}', static function ($locale) {
    if (in_array($locale, config('app.available_locales'), true)) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }

    return redirect()->back();
})->name('localization');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user', static function () {
        return view('user');
    })->name('user');

    Route::get('/profile/show', static function () {
        return redirect()->route('profile.settings');
    })->name('profile.show');

    Route::name('admin.')->prefix('admin')
        ->middleware(['can:manage_data,App\Models\Permission', 'password.confirm'])->group(
            function () {
                Route::get('/', static function () {
                    return redirect(route('admin.users'));
                })->name('main');

                Route::get('/users', [AdminController::class, 'showAllUsers'])->name('users');

                Route::get('/IPs', [AdminController::class, 'showBlockedIPs'])->name('IPs');

                Route::get('/editUser', [AdminController::class, 'editUser'])
                    ->name('editUser');
            }
        );

    Route::middleware(['can:see_notes, App\Models\Permission', 'can:viewAny, App\Models\Note'])->group(function () {
        Route::get('/notes', App\Http\Livewire\Notes\Notes::class)
            ->name('notes');

        Route::get('/notes/edit/{id}', App\Http\Livewire\Notes\NoteEdit::class)
            ->name('notes.edit');
    });

    Route::middleware('can:see_events, App\Models\Permission')->group(function () {
        Route::get('/events', App\Http\Livewire\Events\Events::class)
            ->name('events');
    });

    Route::middleware('can:see_randomizer, App\Models\Permission')->group(function () {
        Route::view('/random', 'random.randomizer')
            ->name('randomizer');
    });
});
