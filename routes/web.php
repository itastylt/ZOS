<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TournamentController;
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
    return view('HomePage');
});
Route::resource('GameManagmentPage', GameController::class);

Route::get('UsersPage', [UserController::class, 'renderUsersPage'])->name('UsersPage.renderUsersPage');
Route::get('UsersPage/{user}', [UserController::class, 'openUserRolePage'])->name('UsersPage.openUserRolePage');
Route::get('changeUserRole/{userId}', [UserController::class, 'changeUserRole'])->name('changeUserRole');

Route::get('/', [GameController::class, 'viewMPGList'])->name('gamesPage');
Route::get('TournamentsPage', [TournamentController::class, 'openTournamentsPage'])->name('tournamentsPage');
