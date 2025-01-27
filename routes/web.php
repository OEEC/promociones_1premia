<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Login;

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
    return view('login-inicio');
});

// Login para invitados
Route::get('/login', Login::class)->name('login')->middleware('guest');

// Rutas protegidas para administradores (Role 0)
Route::get('/administrador', function () {
    return view('administrador');
})->name('dashboard')->middleware(['auth', 'role:0']); // Middleware para administradores

// Rutas protegidas para empleados (Role 1)
Route::get('/tienda', function () {
    return view('tienda');
})->name('canjes')->middleware(['auth', 'role:1']); // Middleware para empleados
Route::get('/historial-tienda', function () {
    return view('historial-tienda');
})->name('historial-tienda')->middleware(['auth', 'role:1']); // Middleware para empleados


// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');