<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ActivityPhotoController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/download-cv', [PortfolioController::class, 'downloadCV'])->name('download.cv');
Route::post('/contact', [PortfolioController::class, 'sendMessage'])->name('contact.send');

// Auth routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin routes (protected)
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('projects', ProjectController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::resource('achievements', AchievementController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('activities', ActivityPhotoController::class);
    Route::get('messages', [MessageController::class, 'index'])->name('admin.messages');
    Route::patch('messages/{message}/read', [MessageController::class, 'markRead'])->name('admin.messages.read');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('admin.messages.destroy');
    Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
});
