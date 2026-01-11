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
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminThreadController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AcademicEventController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerifyPasswordCodeController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Pesan\ConversationController as PesanConversationController;
use App\Http\Controllers\Pesan\MessageController as PesanMessageController;
use App\Http\Controllers\UserSocialLinkController;
use App\Http\Controllers\ProfileCompletionController;
use App\Http\Controllers\Admin\AdminActivityController;

// ===================== AUTH & REGISTER ===================== //
Route::get('/', [AuthController::class, 'showNimForm'])->name('nim.form');
Route::post('/validate-nim', [AuthController::class, 'validateNim'])->name('validate.nim');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/login/register/mahasiswa', [AuthController::class, 'showMahasiswaRegisterPage'])->name('register.mahasiswa');
Route::get('/login/register/dosen', [AuthController::class, 'showDosenRegisterPage'])->name('register.dosen');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// ===================== PASSWORD RESET ===================== //
Route::get('password/forgot', [ForgotPasswordController::class, 'show'])->name('password.forgot');
Route::post('password/forgot', [ForgotPasswordController::class, 'send'])->name('password.forgot.send');

Route::get('password/verify', [VerifyPasswordCodeController::class, 'show'])->name('password.verify');
Route::post('password/verify', [VerifyPasswordCodeController::class, 'verify'])->name('password.verify.post');

Route::get('password/reset', [ResetPasswordController::class, 'show'])->name('password.reset.form');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.post');

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/forum', fn() => redirect()->route('dashboard'))->name('forum');
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
    Route::get('/profile/{id}/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}/delete-photo', [UserController::class, 'deletePhoto'])->name('profile.deletePhoto');
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read.manual');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read.ajax');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

// ===================== SISTEM PESANAN / CHAT ===================== //
Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanConversationController::class, 'index'])->name('pesan.index');
    Route::post('/pesan/conversations', [PesanConversationController::class, 'store'])->name('pesan.conversations.store');
    Route::get('/pesan/conversations/{conversation}/messages', [PesanConversationController::class, 'messages'])->name('pesan.conversations.messages');
    Route::post('/pesan/conversations/{conversation}/messages', [PesanMessageController::class, 'store'])->name('pesan.messages.store');
    Route::post('/pesan/conversations/{conversation}/read', [PesanMessageController::class, 'markRead'])->name('pesan.conversations.read');
});
Route::patch(
    '/pesan/conversations/{conversation}/messages/{message}',
    [PesanMessageController::class, 'update']
)->name('pesan.messages.update')->middleware('auth');

Route::delete(
    '/pesan/conversations/{conversation}/messages/{message}',
    [PesanMessageController::class, 'destroy']
)->name('pesan.messages.destroy')->middleware('auth');


// ===================== ADMIN AREA ===================== //
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('threads', AdminThreadController::class); // <== hanya SATU
    Route::get('/threads/reported', [AdminThreadController::class, 'reported'])->name('threads.reported');
    Route::post('/threads/notify', [AdminThreadController::class, 'notify'])->name('threads.notify');
    Route::resource('comments', AdminCommentController::class);
    Route::get('/comments/reported', [AdminCommentController::class, 'reported'])->name('comments.reported');
    Route::get('/comments/latest', [AdminCommentController::class, 'latest'])->name('comments.latest');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('announcements', AdminAnnouncementController::class); // <== hanya SATU
    Route::post('announcements/notify-all', [AdminAnnouncementController::class, 'notifyAll'])->name('announcements.notifyAll');
    Route::get('/tables', fn() => view('admin.tables'))->name('tables');
    Route::get('/privacy-policy', [LegalController::class, 'adminPrivacyPolicy'])->name('privacy.policy');
    Route::get('/terms-conditions', [LegalController::class, 'adminTermsAndConditions'])->name('terms.conditions');
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    // Manajemen Pesan dari Contact Form
    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{id}/reply', [\App\Http\Controllers\Admin\MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{id}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');
    // Kalender Akademik admin
    Route::get('/kalender', [AcademicEventController::class, 'adminIndex'])->name('calendar.index');
    Route::post('/kalender', [AcademicEventController::class, 'store'])->name('calendar.store');
    Route::put('/kalender/{academicEvent}', [AcademicEventController::class, 'update'])->name('calendar.update');
    Route::delete('/kalender/{academicEvent}', [AcademicEventController::class, 'destroy'])->name('calendar.destroy');
    Route::get('/kalender/api', [AcademicEventController::class, 'adminApiIndex'])->name('calendar.api');
    // Activities
    Route::get('activities', [AdminActivityController::class, 'index'])->name('activities.index');
    // Settings & password admin
    Route::get('/settings', [AdminSettingsController::class, 'show'])->name('settings.show');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::get('/reset-password', [AdminSettingsController::class, 'showResetPassword'])->name('reset-password.show');
    Route::put('/reset-password', [AdminSettingsController::class, 'updatePassword'])->name('reset-password.update');
    // Admin report & stats
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{id}', [AdminReportController::class, 'update'])->name('reports.update');
    Route::get('/stats', [AdminStatsController::class, 'index'])->name('stats.index');
    // Notifikasi user (form kirim manual)
    Route::get('/users/{id}/notify', [AdminUserController::class, 'notifyForm'])->name('users.notify');
    Route::post('/users/{id}/notify', [AdminUserController::class, 'sendNotification']);
    Route::patch('/users/{id}/delete-fields', [AdminUserController::class, 'deleteFields'])->name('users.deleteFields');
    Route::post('/users/add-username', [AdminUserController::class, 'addUsername'])->name('users.addUsername');
});

// ===================== PROFIL PUBLIK USER ===================== //
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');

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

// ===================== NOTIFIKASI USER ===================== //
Route::middleware(['auth'])->group(function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// ===================== LAIN-LAIN ===================== //
Route::get('/leaderboard', [App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard');
Route::view('/about', 'about')->name('about');
Route::view('/terms', 'terms')->name('terms');
Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-conditions', [LegalController::class, 'termsAndConditions'])->name('terms.conditions');
Route::get('/bantuan', function () { return view('bantuan'); })->name('bantuan');
Route::get('/kalender', [AcademicEventController::class, 'index'])->name('calendar.index');
Route::get('/kalender/event/{id}', [AcademicEventController::class, 'show'])->name('calendar.event.show');
Route::get('/api/events', [AcademicEventController::class, 'apiIndex'])->middleware('throttle:60,1');
Route::post('/guest/message', [ContactController::class, 'guestSend'])->name('guest.message.send')->middleware('throttle:6,1');
