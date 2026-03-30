<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

Route::resource('projects', ProjectController::class)->except(['show']);
Route::get('projects/{project}/confirm-delete', [ProjectController::class, 'confirmDelete'])->name('projects.confirm-delete');
