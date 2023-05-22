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

Route::resource('GameManagmentPage', GameController::class);

Route::get('UsersPage', [UserController::class, 'renderUsersPage'])->name('UsersPage.renderUsersPage');
Route::get('UsersPage/{user}', [UserController::class, 'openUserRolePage'])->name('UsersPage.openUserRolePage');
Route::get('changeUserRole/{userId}', [UserController::class, 'changeUserRole'])->name('changeUserRole');
Route::get('/TournamentsPage', [TournamentController::class, 'openTournamentsPage'])->name('openTournamentsPage');
Route::get('/TournamentCreationPage', [TournamentController::class, 'renderTournamentCreationPage'])->name('renderTournamentCreationPage');
Route::get('/', [UserController::class, 'renderHomePage'])->name('renderHomePage');
Route::get('/TournamentsPage', [TournamentController::class, 'openTournamentsPage'])->name('openTournamentsPage');
Route::get('/register', [UserController::class, 'renderRegistration'])->name('renderRegistration');
Route::post('/register/validateForm1', [UserController::class, 'validateForm1'])->name('validateForm1');
Route::get('/login', [UserController::class, 'renderLoginPage'])->name('renderLoginPage');
Route::get('/logout', [UserController::class, 'logOff'])->name('logOff');
Route::post('/login/validateForm', [UserController::class, 'validateForm'])->name('validateForm');

Route::post('TournamentCreationPage/validateForm', [TournamentController::class, 'validateForm'])->name('validateForm');
Route::get('TournamentPage/{id}', [TournamentController::class, 'openTournamentPage'])->name('openTournamentPage');
Route::post('/joinTournament/{id}', [TournamentController::class, 'joinTournament'])->name('joinTournament');
