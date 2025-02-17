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
Route::get('/usuarios', function () {
    return view('admin-usuarios');
})->name('usuarios')->middleware(['auth', 'role:0']); // Middleware para administradores
Route::get('/admin-tiendas', function () {
    return view('admin-tiendas');
})->name('admin-tiendas')->middleware(['auth', 'role:0']); // Middleware para administradores
Route::get('/admin-promociones', function () {
    return view('admin-promociones');
})->name('admin-promociones')->middleware(['auth', 'role:0']); // Middleware para administradores

// Rutas protegidas para empleados (Role 1)
Route::get('/tienda', function () {
    return view('tienda');
})->name('tienda')->middleware(['auth', 'role:1']); // Middleware para empleados
Route::get('/historial-tienda', function () {
    return view('historial-tienda');
})->name('historial-tienda')->middleware(['auth', 'role:1']);
Route::get('/promociones-tienda', function () {
    return view('promociones-tienda');
})->name('promociones-tienda')->middleware(['auth', 'role:1']); // Middleware para empleados



// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');