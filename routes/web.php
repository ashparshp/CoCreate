<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (provided by Laravel Breeze)
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Skills Routes
    Route::resource('skills', SkillController::class);
    
    // Project Routes
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/invite', [ProjectController::class, 'invite'])->name('projects.invite');
    Route::post('/projects/{project}/accept', [ProjectController::class, 'acceptInvite'])->name('projects.accept');
    Route::post('/projects/{project}/decline', [ProjectController::class, 'declineInvite'])->name('projects.decline');
    Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])->name('projects.members.remove');
    
    // Task Routes
    Route::resource('projects.tasks', TaskController::class);
    
    // File Routes
    Route::get('/projects/{project}/files', [FileController::class, 'index'])->name('projects.files.index');
    Route::post('/projects/{project}/files', [FileController::class, 'upload'])->name('projects.files.upload');
    Route::post('/projects/{project}/tasks/{task}/files', [FileController::class, 'upload'])->name('projects.tasks.files.upload');
    Route::get('/projects/{project}/files/{file}/download', [FileController::class, 'download'])->name('projects.files.download');
    Route::delete('/projects/{project}/files/{file}', [FileController::class, 'destroy'])->name('projects.files.destroy');
    
    // Message Routes
    Route::get('/projects/{project}/messages', [MessageController::class, 'index'])->name('projects.messages.index');
    Route::post('/projects/{project}/messages', [MessageController::class, 'store'])->name('projects.messages.store');
    Route::delete('/projects/{project}/messages/{message}', [MessageController::class, 'destroy'])->name('projects.messages.destroy');
    
    // Comment Routes
    Route::post('/projects/{project}/comments', [CommentController::class, 'store'])->name('projects.comments.store');
    Route::post('/projects/{project}/tasks/{task}/comments', [CommentController::class, 'store'])->name('projects.tasks.comments.store');
    Route::put('/projects/{project}/comments/{comment}', [CommentController::class, 'update'])->name('projects.comments.update');
    Route::delete('/projects/{project}/comments/{comment}', [CommentController::class, 'destroy'])->name('projects.comments.destroy');
});