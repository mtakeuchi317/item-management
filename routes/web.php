<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('index');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('items.add');
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('item/edit');
    Route::post('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('item/edit');
    Route::delete('/delete/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('item/delete');
    Route::get('/itemsinfo/{id}', [App\Http\Controllers\ItemController::class, 'itemsinfo'])->name('itemsinfo');
    Route::get('/{category}', [App\Http\Controllers\ItemController::class, 'showByCategory'])->name('items.by.category');
});

Route::prefix('users')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'list']);
    Route::get('edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user/edit');
    Route::post('edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user/edit');
});
