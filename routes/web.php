<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome')->middleware('guest')->name('login');

// Route::view('home', 'home')
//     ->middleware(['auth', 'verified'])
//     ->name('home');
// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

Route::middleware('auth')->group(function () {
    Volt::route('/home', 'pages.home')->name('home');
    Volt::route('/category/{category}', 'pages.categories.category')->name('category');
    Volt::route('/summary', 'pages.categories.summary')->name('summary');
});

require __DIR__.'/auth.php';
