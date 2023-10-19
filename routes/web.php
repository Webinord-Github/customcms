<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BlogController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/admin', function() {
    return view('admin.index');
})->middleware('admin');


Route::resource('/admin/users', 'App\Http\Controllers\Admin\UsersController');

Route::put('/admin/users/{user}/status', 'App\Http\Controllers\Admin\UsersController@updateUserPassword')->name('users.update-password');

Route::resource('/admin/medias', 'App\Http\Controllers\Admin\MediasController');

Route::resource('/admin/pages', 'App\Http\Controllers\Admin\PagesController');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
})->middleware('admin');

Route::get('/{url}', 'App\Http\Controllers\Admin\PagesController@view')->name('home.page');

Route::get('/admin/posts', [BlogController::class, 'posts'])->name('posts')->middleware('auth');
Route::get('/admin/posts/create', [BlogController::class, 'create'])->middleware('auth');
Route::post('/admin/posts/store', [BlogController::class, 'store'])->middleware('auth');
Route::get('/admin/posts/update/{id}', [BlogController::class, 'update'])->middleware('auth');
Route::post('/admin/posts/update/', [BlogController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/posts/destroy/{id}', [BlogController::class, 'destroy'])->middleware('auth');


require __DIR__.'/auth.php';
