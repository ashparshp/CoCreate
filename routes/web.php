<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes (provided by Laravel Breeze)
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Add these routes to the existing web.php file inside the auth middleware group
    Route::post('/skills/add-to-profile', [SkillController::class, 'addToProfile'])->name('skills.addToProfile');
    Route::delete('/skills/{skill}/remove-from-profile', [SkillController::class, 'removeFromProfile'])->name('skills.removeFromProfile');

    // Add these routes to the existing web.php file inside the auth middleware group
    Route::post('/projects/{project}/request-join', [ProjectController::class, 'requestJoin'])->name('projects.request-join');
    Route::post('/projects/{project}/approve-join-request/{requestId}', [ProjectController::class, 'approveJoinRequest'])->name('projects.approve-join-request');
    Route::post('/projects/{project}/reject-join-request/{requestId}', [ProjectController::class, 'rejectJoinRequest'])->name('projects.reject-join-request');
    Route::post('/projects/{project}/cancel-join-request', [ProjectController::class, 'cancelJoinRequest'])->name('projects.cancel-join-request');

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

// Admin routes - Updated to use fully qualified middleware class name
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Users management
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        
        // Projects management
        Route::get('/projects', [AdminController::class, 'projects'])->name('projects.index');
        Route::get('/projects/{project}', [AdminController::class, 'showProject'])->name('projects.show');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.destroy');
        
        // Skills management
        Route::get('/skills', [AdminController::class, 'skills'])->name('skills.index');
        Route::get('/skills/create', [AdminController::class, 'createSkill'])->name('skills.create');
        Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
        Route::get('/skills/{skill}/edit', [AdminController::class, 'editSkill'])->name('skills.edit');
        Route::put('/skills/{skill}', [AdminController::class, 'updateSkill'])->name('skills.update');
        Route::delete('/skills/{skill}', [AdminController::class, 'deleteSkill'])->name('skills.destroy');
        
        // System settings
        Route::get('/settings', [AdminController::class, 'systemSettings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSystemSettings'])->name('settings.update');
    });
    