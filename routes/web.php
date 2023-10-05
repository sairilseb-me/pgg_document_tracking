<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\RerouteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::middleware('auth')->group(function () {
    Route::patch('/file-received/{id}', [IncomingController::class, 'fileReceived'])->name('file.received');
    Route::post('/reroutes-disapproved/{incoming_id}/{reroute_id}', [RerouteController::class, 'disapproveReroute']);
    Route::post('/request-reroute/{id}', [RerouteController::class, 'requestReroute']);
    Route::resource('incoming', IncomingController::class);
    Route::resource('/users', UserController::class);
});

Route::middleware(['auth', 'isSuperAdminAndAdmin'])->group(function() {
    Route::resource('/files', FilesController::class);
    Route::resource('/reroutes', RerouteController::class);
});

Route::get('/about', function () {
    return view('about');
})->name('about');
