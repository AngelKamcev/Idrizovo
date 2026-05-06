<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

// Home page
Route::get('/', [PagesController::class, 'index'])->name('index');

// About us page
Route::get('/about', [PagesController::class, 'aboutus'])->name('aboutus');

// Activities page
Route::get('/activities', [PagesController::class, 'activities'])->name('activities');

// Contact page
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');

// Soopstenija (announcements) page
Route::get('/soopstenija', [PagesController::class, 'soopstenija'])->name('soopstenija');

// Izrabotki (crafts) page
Route::get('/izrabotki', [PagesController::class, 'izrabotki'])->name('izrabotki');

// Gallery page
Route::get('/gallery', [PagesController::class, 'gallery'])->name('gallery');

// ADMIN PANEL ROUTES
Route::prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Admin Activities (Index)
    Route::get('/activities', function () {
        return view('admin.index_activities');
    })->name('admin.activities');

    // Admin Soopstenija
    Route::get('/soopstenija', function () {
        return view('admin.soopstenija');
    })->name('admin.soopstenija');

    // Admin Izrabotki
    Route::get('/izrabotki', function () {
        return view('admin.izrabotki');
    })->name('admin.izrabotki');

    // Admin Gallery
    Route::get('/gallery', function () {
        return view('admin.gallery');
    })->name('admin.gallery');

    // Admin About Us
    Route::get('/aboutus', function () {
        return view('admin.aboutus');
    })->name('admin.aboutus');

    // Admin Activities (Main)
    Route::get('/main-activities', function () {
        return view('admin.activities');
    })->name('admin.main-activities');
});
