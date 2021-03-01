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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', [TodoController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [TodoController::class, 'todo'])->name('todo');
    Route::post('/add-task', [TodoController::class, 'add'])->name('add_todo');
    Route::post('/update-task/{id}', [TodoController::class, 'update'])->name('update_todo');
    Route::get('/delete/{id}', [TodoController::class, 'delete'])->name('delete');
    Route::get('/view/{id}', [TodoController::class, 'view'])->name('view_todo');
    Route::get('/my-task', [TodoController::class, 'myTodo'])->name('my_todo');
});
