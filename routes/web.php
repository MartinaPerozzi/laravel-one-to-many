<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// }); Questa la sposto in GuestHomeController - e qui scrivo:
Route::get('/', [GuestHomeController::class, 'index'])->name('home');

Route::get('/welcome', [GuestHomeController::class, 'index'])->name('welcome');
// Prova di aggiungere una show per gli users-frontend
Route::get('/detail', [GuestHomeController::class, 'show'])->name('detail');

Route::get('/dashboard', [AdminHomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Il "verified" va configurato e non lo usiamo ancora, quindi si potrebbe togliere al momento

Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::get('projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
        Route::put('projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
        Route::delete('projects/{project}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.force-delete');

        // Rotta TYPES
        Route::resource('types', TypeController::class);

        Route::resource('projects', ProjectController::class)
            ->parameters(['projects' => 'project:slug']);
    });


Route::middleware('auth')

    ->prefix('/profile') // Dico che il prefisso degli url è sempre profile
    ->name('profile.')   //Dico che il prefisso del name (nomi delle rotte ) è sempre profile
    ->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

require __DIR__ . '/auth.php';
