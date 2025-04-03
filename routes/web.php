routes/web.php

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [UsersController::class, 'login'])->name('users.login');
Route::post('/login', [UsersController::class, 'checkuser'])->name('users.checkuser');
Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');
