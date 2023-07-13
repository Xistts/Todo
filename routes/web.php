<?php

use App\Http\Controllers\TodoController;
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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('/')->as('todos.')->controller(TodoController::class)->group(function(){

        Route::get('', 'index')->name('index');
        
        Route::get('index', 'index')->name('index');

        Route::post('search', 'search')->name('search');

        Route::get('create', 'create')->name('create');

        Route::post('store', 'store')->name('store');

        Route::get('show/{id}', 'show')->name('show');

        Route::get('{id}/edit', 'edit')->name('edit');

        Route::put('update', 'update')->name('update');

        Route::delete('destroy', 'destroy')->name('destroy');

    });
});
