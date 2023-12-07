<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChampionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JoinController;


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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('champions/trash', [ChampionController::class, 'deletelist']);
    Route::get('champions/trash/{champion}/restore', [ChampionController::class, 'restore']);
    Route::get('champions/trash/{champion}/forcedelete', [ChampionController::class, 'deleteforce']);
    Route::resource('champions', ChampionController::class);
    Route::get('positions/trash', [PositionController::class, 'deletelist']);
    Route::get('positions/trash/{position}/restore', [PositionController::class, 'restore']);
    Route::get('positions/trash/{position}/forcedelete', [PositionController::class, 'deleteforce']);
    Route::resource('positions', PositionController::class);
    Route::get('jobs/trash', [JobController::class, 'deletelist']);
    Route::get('jobs/trash/{job}/restore', [JobController::class, 'restore']);
    Route::get('jobs/trash/{job}/forcedelete', [JobController::class, 'deleteforce']);
    Route::resource('jobs', JobController::class);
    Route::get('/totals', [JoinController::class,'index']);
});