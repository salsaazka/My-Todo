<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::middleware('isGuest')->group(function(){
    Route::get('/', [ProjectController::class, 'login'])->name('login');
    Route::get('/register', [ProjectController::class, 'register']);
    Route::post('/', [ProjectController::class, 'inputRegister'])->name('register.post');
    Route::post('/login', [ProjectController::class, 'auth'])->name('login.auth');
});

Route::get('/home', [ProjectController::class, 'index'])->name('home');

Route::get('/logout', [ProjectController::class, 'logout'])->name('logout');

Route::middleware('isLogin')->prefix('/project')->name('project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/create', [ProjectController::class, 'store'])->name('store');

    //kalau ada {} artinya data dinamis diambil dari laravel
    Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('edit');
    Route::patch('/update/{id}', [ProjectController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ProjectController::class, 'destroy'])->name('destroy');
    Route::get('/projects/pdf', [ProjectController::class, 'createPDF']);
});

//ada route pakai {} artinya parameter path yang dinamis, jadi path nya harus diisi data dinamis dari database
//untuk function controller juga harus memberi jumlah parameter sama dengan jumlah parameter sama dengan jumlah path dinamis pada route
Route::middleware('isLogin')->prefix('/task/{project}')->name('task.')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/store', [TaskController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('edit');
    //untuk update , bisa pakai patch atau put
    //penggunaanya disamakan dengan @method()
    Route::patch('/update/{id}', [TaskController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [TaskController::class, 'destroy'])->name('destroy');
    Route::get('/tasks/pdf', [TaskController::class, 'createPDF']);
});