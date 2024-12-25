<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    // If the user is not logged in, render the login page using Inertia
    //return Inertia::render('login');
    return redirect()->route('login');


    // Otherwise, render the Welcome page
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Jobsite/index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/postjob', function () {
    return Inertia::render('Jobsite/AddNewJob');
})->middleware(['auth', 'verified'])->name('postjob');

Route::get('/jobs', function () {
    return Inertia::render('Jobsite/ViewJob');
})->middleware(['auth', 'verified'])->name('myNetwork');

Route::get('/job', function () {
    return Inertia::render('Jobsite/aboutMe');
})->middleware(['auth', 'verified'])->name('aboutme');

require __DIR__ . '/auth.php';
