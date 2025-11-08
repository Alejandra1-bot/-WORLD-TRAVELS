<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('/logout', function () {
    // Aquí podrías manejar logout si es necesario, pero como es API, quizás redirigir
    return redirect()->route('home');
})->name('logout');
