<?php

use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\BlogsViewWebController;
use App\Http\Controllers\Web\BlogsWebController;
use App\Http\Controllers\Web\ContactUsWebController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;


//* admin panel
Route::prefix('admin')->middleware('throttle:only_three_time')->group(function () {
    Route::resource('blog', BlogsController::class);
});

// Web
// Route::get('/', [BlogsWebController::class, 'index']);
Route::get('blogsview/{slug}', [BlogsViewWebController::class, 'index']);

//*login routes start
Route::prefix('admin')->group(function () {
    Route::get('dashboard', function () {
        return view('Admin.template');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
//*login routes end



//* portfolio Web
Route::resource('/', HomeController::class);
Route::get('/portfolio-details/{id}', [HomeController::class, 'portfoliodetails']);
Route::get('/android-app/{id}', [HomeController::class, 'appdetails']);
Route::resource('/contact', ContactUsWebController::class);
Route::get('img/{name}', [ContactUsWebController::class, 'download']);



Route::get('/service-details', function () {
    return view('web.pages.service.service');
});
Route::get('/starter-page', function () {
    return view('web.pages.starter.starter');
});

//* portfolio Web end hare

//portfolio live 