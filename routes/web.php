<?php

use Illuminate\Support\Facades\Route;
use App\Practice;
use App\Http\Controllers\PracticeController;
use App\Models\Movie;
use App\Http\Controllers\MovieController;

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

Route::get('/practice', [PracticeController::class,'sample']);
Route::get('/practice2', [PracticeController::class,'sample2']);
Route::get('/practice3', [PracticeController::class,'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/search', [MovieController::class, 'search']);
Route::get('/movies/{id}', [MovieController::class, 'detail'])->name('detail');
Route::get('/movies/{movie_id}/schedules/{schedule_id}/sheets', [MovieController::class, 'movieSheet'])->name('movieSheet');
Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create', [MovieController::class, 'sheetReserve'])->name('sheetReserve');

Route::get('/admin/movies', [MovieController::class, 'adminIndex']);
Route::get('/admin/movies/create', [MovieController::class, 'adminCreate'])->name('create');
Route::get('/admin/movies/{id}', [MovieController::class, 'adminDetail'])->name('adminDetail');
Route::post('/admin/movies/store', [MovieController::class, 'adminStore']); // postは新規作成
Route::get('/admin/movies/{id}/edit', [MovieController::class, 'adminEdit'])->name('edit'); // createの感覚
Route::patch('/admin/movies/{id}/update', [MovieController::class, 'adminUpdate'])->name('update'); // storeの感覚 patchは修正

Route::delete('/admin/movies/{id}/destroy',[MovieController::class, 'adminDestroy'])->name('destroy');
Route::get('/admin/schedules',[MovieController::class, 'adminSchedules'])->name('schedules');
Route::get('/admin/schedules/{id}',[MovieController::class, 'adminSchedulesShow'])->name('schedulesshow');
Route::get('/admin/movies/{id}/schedules/create',[MovieController::class, 'adminSchedulesCreate'])->name('adminSchedulesCreate');
Route::get('/admin/schedules/{id}/edit',[MovieController::class, 'adminSchedulesEdit'])->name('adminSchedulesEdit');
Route::patch('/admin/schedules/{id}/update',[MovieController::class, 'adminUpdateSchedules'])->name('adminUpdateSchedules');
// Route::post('/admin/movies/{id}/schedules/store',[MovieController::class, 'adminStoreSchedules'])->name('adminStoreSchedules');
Route::post('/admin/movies/{id}/schedules/store',[MovieController::class, 'adminStoreSchedules']);
Route::delete('/admin/schedules/{id}/destroy',[MovieController::class, 'adminDestroySchedules'])->name('destroySchedules');

Route::get('/sheets', [MovieController::class, 'sheets'])->name('sheets');