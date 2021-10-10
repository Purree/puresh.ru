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

Route::get('/', function () {
    return view('home');
})->name('main');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/user', function () {
        return view('user');
    })->name('user');

    Route::get('/profile/show', function () {
        return redirect()->route('profile.settings');
    })->name('profile.show');


    Route::name('admin.')->middleware(['can:administrate,App\Models\Permission', 'password.confirm'])->group(function() {
        Route::get('/admin', [AdminController::class, 'showAllUsers'])
            ->name('main');

        Route::get('/admin/editUser', [AdminController::class, 'editUser'])
            ->name('editUser');
    });

    Route::middleware('canany:App\Models\Permission,administrate,see_notes')->group(function() {
        Route::get('/notes', function () {
            return view('notes.notes');
        })->name('notes');
    });
});






require_once __DIR__ . '/jetstream.php';
