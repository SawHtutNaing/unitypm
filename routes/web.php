<?php

use App\Livewire\ProjectManager;
use Illuminate\Support\Facades\Route;
use App\Livewire\TaskManager;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    Route::get('/', ProjectManager::class)->name('projects')
    ->middleware(['auth'])


    ;

    Route::get('/projects/{projectId}/tasks', TaskManager::class)->name('tasks');


require __DIR__.'/auth.php';
