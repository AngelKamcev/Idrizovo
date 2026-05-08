<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\VisitScheduleController;

// Home page
Route::get('/', [PagesController::class, 'index'])->name('index');

// About us page
Route::get('/about', [PagesController::class, 'aboutus'])->name('aboutus');

// Activities page
Route::get('/activities', [PagesController::class, 'activities'])->name('activities');

// Contact page
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [PagesController::class, 'storeContact'])->name('contact.submit');

// Soopstenija (announcements) page
Route::get('/soopstenija', [PagesController::class, 'soopstenija'])->name('soopstenija');

// Izrabotki (crafts) page
Route::get('/izrabotki', [PagesController::class, 'izrabotki'])->name('izrabotki');

// Gallery page
Route::get('/gallery', [PagesController::class, 'gallery'])->name('gallery');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
    Route::post('/account', [ProfileController::class, 'update'])->name('account.update');
});

// ADMIN PANEL ROUTES
Route::prefix('admin')->middleware('auth')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/visit-schedules', [VisitScheduleController::class, 'index'])->name('admin.visit-schedules');
    Route::post('/visit-schedules', [VisitScheduleController::class, 'store'])->name('admin.visit-schedules.store');
    Route::patch('/visit-schedules/{visitSchedule}', [VisitScheduleController::class, 'update'])->name('admin.visit-schedules.update');
    Route::delete('/visit-schedules/{visitSchedule}', [VisitScheduleController::class, 'destroy'])->name('admin.visit-schedules.destroy');

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

    // Admin Complaints / Praise messages
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('admin.complaints');
    Route::patch('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('admin.complaints.update');

    // Admin Activities (Main)
    Route::get('/main-activities', function () {
        return view('admin.activities');
    })->name('admin.main-activities');
});
