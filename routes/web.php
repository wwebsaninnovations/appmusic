<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\MusicController;
use App\Http\Controllers\Admin\ReleaseController;
use App\Http\Controllers\ThemeController;
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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

// Route to handle the theme change
Route::post('/theme/change', [ThemeController::class, 'changeTheme'])->name('theme.change');
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::get('/users/trashed', [UserController::class, 'trashedUsers'])->name('users.trashed');
Route::post('/users/{id}/restore', [UserController::class, 'restoreUser'])->name('users.restore');
Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser'])->name('users.delete');



Route::get('/musics/create/step1', [MusicController::class, 'step1'])->name('musics.step1');
Route::post('/musics/create/step1', [MusicController::class, 'saveStep1'])->name('musics.step1.save');

Route::get('/musics/create/step2', [MusicController::class, 'step2'])->name('musics.step2');
Route::post('/musics/create/step2', [MusicController::class, 'saveStep2'])->name('musics.step2.save');

Route::get('/musics/create/step3', [MusicController::class, 'step3'])->name('musics.step3');



//Edit Route
Route::get('/musics/edit/step1/{id}', [MusicController::class, 'editStep1'])->name('musics.editStep1');
Route::post('/musics/edit/step1', [MusicController::class, 'updateStep1'])->name('musics.editStep1.update');

Route::get('/musics/edit/step2/{id}', [MusicController::class, 'editStep2'])->name('musics.editStep2');
Route::post('/musics/edit/step2', [MusicController::class, 'updateStep2'])->name('musics.editStep2.update');

Route::get('/musics/edit/step3/{id}', [MusicController::class, 'editStep3'])->name('musics.editStep3');

//Generate TrackCode

Route::get('/musics/generateTrackCode', [MusicController::class, 'generateTrackCode'])->name('musics.trackCode');

//RELEASE CONTROLLER
Route::get('/releases/create/step1', [ReleaseController::class, 'step1'])->name('releases.step1');
Route::post('/releases/create/step1', [ReleaseController::class, 'saveStep1'])->name('releases.step1.save');

Route::get('/releases/create/step2', [ReleaseController::class, 'step2'])->name('releases.step2');
Route::post('/releases/create/basic', [ReleaseController::class, 'saveBasic'])->name('releases.basic.save');
Route::post('/releases/create/artwork', [ReleaseController::class, 'saveArtwork'])->name('releases.artwork.save');

Route::resources([
    // 'books' => BookController::class,
    'roles' => RoleController::class,
    'users' => UserController::class,
    'musics'=> MusicController::class,
    'releases' =>ReleaseController:: class
]);


