<?php

use App\Http\Controllers\UsersController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UsersController::class,'index'])->name('matex.index');
Route::get('/create',[UsersController::class,'create'])->name('matex.create');
Route::post('/store',[UsersController::class,'store'])->name('matex.store');
Route::get('/edit/{id}',[UsersController::class,'edit'])->name('matex.edit');
Route::put('matex/{id}', [UsersController::class, 'update'])->name('matex.update');
Route::delete('matex', [UsersController::class, 'destroy'])->name('matex.destroy');


Route::get('matex/import', [UsersController::class, 'importView'])->name('matex.import.view');
Route::post('matex/import', [UsersController::class, 'import'])->name('matex.import');
Route::post('matex/import/submit', [UsersController::class, 'importSubmit'])->name('matex.import.submit');


