<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController as AdminUserController;
use App\Http\Controllers\Admin\AdminThreadController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\AdminSettingsController;

// ===================== AUTH & REGISTER ===================== //
Route::get('/', [AuthController::class, 'showNimForm'])->name('nim.form');
Route::post('/validate-nim', [AuthController::class, 'validateNim'])->name('validate.nim');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/login/register/mahasiswa', [AuthController::class, 'showMahasiswaRegisterPage'])->name('register.mahasiswa');
Route::get('/login/register/dosen', [AuthController::class, 'showDosenRegisterPage'])->name('register.dosen');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// ===================== OTP VERIFICATION ===================== //
Route::get('/register/verify-otp', [AuthController::class, 'showUserOtpForm'])->name('user.otp.form');
Route::post('/register/verify-otp', [AuthController::class, 'verifyUserOtp'])->name('user.otp.verify');
Route::post('/register/resend-otp', [AuthController::class, 'resendUserOtp'])->name('user.otp.resend');

// ===================== LENGKAPI PROFIL (SETELAH OTP, SEBELUM LOGIN) ===================== //
Route::get('/lengkapi-profil/{user_id}', [UserController::class, 'showCompleteProfileForm'])->name('profile.complete');
Route::post('/lengkapi-profil/{user_id}', [UserController::class, 'submitCompleteProfile'])->name('profile.complete.submit');

// ===================== ADMIN AUTH ===================== //
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('login.admin');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('login.admin.submit');
Route::get('/admin/otp', [AdminLoginController::class, 'showOtpForm'])->name('otp.admin');
Route::post('/admin/otp', [AdminLoginController::class, 'verifyOtp'])->name('otp.admin.verify');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ===================== USER AREA (SETELAH LOGIN) ===================== //
Route::middleware('auth')->group(function () {
    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/forum', fn() => redirect()->route('dashboard'))->name('forum');

    // Forum, Pertanyaan, Komentar, Laporan, Profil sendiri
    Route::resource('questions', QuestionController::class)->except(['show']);
    Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/questions/search', [QuestionController::class, 'search'])->name('questions.search');
    Route::get('/questions/hashtag/{id}', [QuestionController::class, 'byHashtag'])->name('questions.byHashtag');
    Route::post('/questions/{id}/like', [QuestionController::class, 'like'])->name('questions.like');
    Route::get('/questions/tag/{name}', [QuestionController::class, 'byTag'])->name('questions.byTag');
    Route::get('/questions/user/{username}', [QuestionController::class, 'byUser'])->name('questions.byUser');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');

    // Profil sendiri
    Route::get('/profile/{id}/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}/delete-photo', [UserController::class, 'deletePhoto'])->name('profile.deletePhoto');

    // Report
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read.manual');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read.ajax');
});

// ===================== ADMIN AREA ===================== //
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::get('/tables', fn() => view('admin.tables'))->name('tables');
    Route::get('/threads/reported', [AdminThreadController::class, 'reported'])->name('threads.reported');
    Route::get('/comments/reported', [AdminCommentController::class, 'reported'])->name('comments.reported');
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/notify', [AdminCommentController::class, 'notify'])->name('comments.notify');
    Route::get('/threads/{id}', [AdminThreadController::class, 'show'])->name('threads.show');
    Route::post('/threads/notify', [AdminThreadController::class, 'notify'])->name('threads.notify');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('threads', App\Http\Controllers\Admin\AdminThreadController::class);
});
Route::patch('/admin/users/{id}/delete-fields', [AdminUserController::class, 'deleteFields'])->name('admin.users.deleteFields');
Route::get('/admin/users/{id}/notify', [AdminUserController::class, 'notifyForm'])->name('admin.users.notify');
Route::post('/admin/users/{id}/notify', [AdminUserController::class, 'sendNotification']);
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pengguna
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/reported', [AdminUserController::class, 'reported'])->name('users.reported');

    // Thread & Komentar
    Route::get('/threads', [AdminThreadController::class, 'index'])->name('threads.index');
    Route::get('/comments/latest', [AdminCommentController::class, 'latest'])->name('comments.latest');

    // Kategori Forum
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');

    // Laporan & Moderasi
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

    // Statistik Forum
    Route::get('/stats', [AdminStatsController::class, 'index'])->name('stats.index');

    // Pengumuman
    Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
    });
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    });
    Route::get('/admin/announcements/{id}', [AdminAnnouncementController::class, 'show'])->name('admin.announcements.show');
    Route::resource('announcements', App\Http\Controllers\Admin\AdminAnnouncementController::class);

// ===================== PROFIL PUBLIK USER ===================== //
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// ===================== LOGOUT & CONTACT ===================== //
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/contact', fn() => view('contact'))->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// ===================== DEBUG (OPSIONAL) ===================== //
Route::get('/debug-kernel', fn() => app()->make(\Illuminate\Contracts\Http\Kernel::class)::class);

Route::prefix('admin/categories')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/{id}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::post('/{id}/update', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
});

Route::prefix('admin/announcements')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/', [AdminAnnouncementController::class, 'index'])->name('admin.announcements.index');
    Route::get('/create', [AdminAnnouncementController::class, 'create'])->name('admin.announcements.create');
    Route::post('/store', [AdminAnnouncementController::class, 'store'])->name('admin.announcements.store');
    Route::get('/{id}/edit', [AdminAnnouncementController::class, 'edit'])->name('admin.announcements.edit');
    Route::post('/{id}/update', [AdminAnnouncementController::class, 'update'])->name('admin.announcements.update');
    Route::delete('/{id}', [AdminAnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');
});

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::post('/admin/users/add-username', [AdminUserController::class, 'addUsername'])->name('admin.users.addUsername');
Route::post('/admin/announcements/notify-all', [AdminAnnouncementController::class, 'notifyAll'])->name('admin.announcements.notifyAll');
Route::get('/admin/announcements/{id}', [AdminAnnouncementController::class, 'show'])->name('admin.announcements.show');

Route::middleware(['auth'])->group(function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::patch('/admin/reports/{id}', [AdminReportController::class, 'update'])->name('admin.reports.update');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/settings', [AdminSettingsController::class, 'show'])->name('admin.settings.show');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');

    Route::get('/reset-password', [AdminSettingsController::class, 'showResetPassword'])->name('admin.reset-password.show');
    Route::put('/reset-password', [AdminSettingsController::class, 'updatePassword'])->name('admin.reset-password.update');

});

Route::get('/admin/comments', [CommentController::class, 'index'])->name('admin.comments.index');
Route::resource('admin/threads', AdminThreadController::class)->names('admin.threads');
Route::post('admin/threads/notify', [AdminThreadController::class, 'notify'])->name('admin.threads.notify');
