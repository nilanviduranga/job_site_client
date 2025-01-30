<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Models\category;
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



//-----------About Me Routes----------------

Route::get('/job', function () {
    return Inertia::render('Jobsite/aboutMe');
})->middleware(['auth', 'verified'])->name('aboutme');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ClientController::class, 'getProfile'])->name('profile.get');
    Route::put('/profile', [ClientController::class, 'updateProfile'])->name('profile.update');
});


//-----------My Jobs Routes----------------
// Route to fetch categories
Route::get('/categories', function () {
    return category::all();
})->name('categories.get');

Route::get('/jobs', function () {
    return Inertia::render('Jobsite/ViewJob');
})->middleware(['auth', 'verified'])->name('myNetwork');
Route::post('/jobs', [JobController::class, 'store'])->name('store_jobs');

Route::get('/fetch/myJobs', [JobController::class, 'fetch_my_jobs'])->name('fetch_my_jobs');

Route::post('/fetch/myJobs/responce', [JobController::class, 'view_response'])->name('view_response');

Route::post('/hire-candidate', [JobController::class, 'hireCandidate'])->name('hire_candidate');
Route::post('/reject-candidate', [JobController::class, 'rejectCandidate'])->name('reject_candidate');

//Posted Jobs Fromn me
Route::post('/delete/job', [JobController::class, 'delete_job'])->name('delete_job');

//-----home page----
Route::get('/fetch/available-jobs', [HomeController::class, 'fetch_available_jobs'])->name('fetch_available_jobs');
Route::post('apply/to-job', [HomeController::class, 'apply_to_job'])->name('apply_to_job')->middleware('auth');

//------myJ0bs-----
Route::get('/myjobs', function () {
    return Inertia::render('Jobsite/myJobs');
})->middleware(['auth', 'verified'])->name('myJobs');
Route::get('/fetch/applied-jobs', [HomeController::class, 'fetch_Applyed_jobs'])->name('fetch_Applyed_jobs')->middleware('auth');


require __DIR__ . '/auth.php';
