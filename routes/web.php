<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

// Now includes show
Route::resource('projects', ProjectController::class);

Route::get('projects/{project}/confirm-delete', [ProjectController::class, 'confirmDelete'])
    ->name('projects.confirm-delete');

Route::get('trash', [ProjectController::class, 'trash'])
    ->name('projects.trash');

Route::post('trash/{project}/restore', [ProjectController::class, 'restore'])
    ->withTrashed()
    ->name('projects.restore');

Route::delete('trash/{project}/force-delete', [ProjectController::class, 'forceDelete'])
    ->withTrashed()
    ->name('projects.force-delete');