<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\VisitRequestController;
use App\Http\Controllers\Admin\VisitScheduleController;
use App\Http\Controllers\Admin\HandcraftController;
use App\Http\Controllers\Admin\GalleryController;

// Closure to define shared public routes
$publicRoutes = function () {
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

    // Book visit page
    Route::get('/zakazi-poseta', [PagesController::class, 'zakaziPoseta'])->name('zakazi-poseta');
    Route::post('/zakazi-poseta', [PagesController::class, 'storeVisitRequest'])->name('zakazi-poseta.submit');

    // Authentication routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
        Route::post('/account', [ProfileController::class, 'update'])->name('account.update');
    });
};

// PUBLIC ROUTES WITH LANGUAGE PREFIXES
// Macedonian routes (mk)
Route::prefix('mk')->middleware('setLocale')->group($publicRoutes);

// English routes (en)
Route::prefix('en')->middleware('setLocale')->group($publicRoutes);

// Albanian routes (sq)
Route::prefix('sq')->middleware('setLocale')->group($publicRoutes);

// Root routes (default to Macedonian)
$publicRoutes();

// ADMIN PANEL ROUTES
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('admin.settings.password');

    Route::middleware('role:admin')->group(function () {
        Route::post('/settings/users', [SettingsController::class, 'storeUser'])->name('admin.settings.users');
        Route::get('/visit-requests', [VisitRequestController::class, 'index'])->name('admin.visit-requests');
        Route::patch('/visit-requests/{visitRequest}', [VisitRequestController::class, 'update'])->name('admin.visit-requests.update');
    });

    Route::middleware('role:admin,vospituvac')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/visit-schedules', [VisitScheduleController::class, 'index'])->name('admin.visit-schedules');
        Route::post('/visit-schedules', [VisitScheduleController::class, 'store'])->name('admin.visit-schedules.store');
        Route::patch('/visit-schedules/{visitSchedule}', [VisitScheduleController::class, 'update'])->name('admin.visit-schedules.update');
        Route::delete('/visit-schedules/{visitSchedule}', [VisitScheduleController::class, 'destroy'])->name('admin.visit-schedules.destroy');

        // Main Activities (carousel activities)
        Route::prefix('main-activities')->name('admin.main-activities.')->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('index');
            Route::get('/create', [ActivityController::class, 'create'])->name('create');
            Route::post('/', [ActivityController::class, 'store'])->name('store');
            Route::get('/{activity}/edit', [ActivityController::class, 'edit'])->name('edit');
            Route::patch('/{activity}', [ActivityController::class, 'update'])->name('update');
            Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
        });

        Route::get('/activities', function () {
            return view('admin.index_activities');
        })->name('admin.activities');

        // Announcements (Soopstenija)
        Route::prefix('announcements')->name('admin.announcements.')->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('index');
            Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
            Route::post('/', [AnnouncementController::class, 'store'])->name('store');
            Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
            Route::patch('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
        });

        // Redirect old soopstenija route to announcements
        Route::redirect('/soopstenija', '/admin/announcements');

        Route::get('/izrabotki', [HandcraftController::class, 'index'])->name('admin.izrabotki');
        Route::get('/izrabotki/{slug}/edit', [HandcraftController::class, 'edit'])->name('admin.izrabotki.edit');
        Route::patch('/izrabotki/{slug}', [HandcraftController::class, 'update'])->name('admin.izrabotki.update');

        Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

        Route::get('/aboutus', function () {
            return view('admin.aboutus');
        })->name('admin.aboutus');
    });

    Route::middleware('role:reviewer')->group(function () {
        Route::get('/complaints', [ComplaintController::class, 'index'])->name('admin.complaints');
        Route::patch('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('admin.complaints.update');
    });
});
