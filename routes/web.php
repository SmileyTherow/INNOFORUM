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

/*
|--------------------------------------------------------------------------
| Public / Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showNimForm'])->name('nim.form');
Route::post('/validate-nim', [AuthController::class, 'validateNim'])->name('validate.nim');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/login/register/mahasiswa', [AuthController::class, 'showMahasiswaRegisterPage'])->name('register.mahasiswa');
Route::get('/login/register/dosen', [AuthController::class, 'showDosenRegisterPage'])->name('register.dosen');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

/*
|--------------------------------------------------------------------------
| Password reset & OTP
|--------------------------------------------------------------------------
*/
Route::get('password/forgot', [ForgotPasswordController::class, 'show'])->name('password.forgot');
Route::post('password/forgot', [ForgotPasswordController::class, 'send'])->name('password.forgot.send');

Route::get('password/verify', [VerifyPasswordCodeController::class, 'show'])->name('password.verify');
Route::post('password/verify', [VerifyPasswordCodeController::class, 'verify'])->name('password.verify.post');

Route::get('password/reset', [ResetPasswordController::class, 'show'])->name('password.reset.form');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.post');

Route::get('/register/verify-otp', [AuthController::class, 'showUserOtpForm'])->name('user.otp.form');
Route::post('/register/verify-otp', [AuthController::class, 'verifyUserOtp'])->name('user.otp.verify');
Route::post('/register/resend-otp', [AuthController::class, 'resendUserOtp'])->name('user.otp.resend');

/*
|--------------------------------------------------------------------------
| Profile completion (before login)
|--------------------------------------------------------------------------
*/
Route::get('/lengkapi-profil/{user_id}', [UserController::class, 'showCompleteProfileForm'])->name('profile.complete');
Route::post('/lengkapi-profil/{user_id}', [UserController::class, 'submitCompleteProfile'])->name('profile.complete.submit');

/*
|--------------------------------------------------------------------------
| Admin authentication
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('login.admin');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('login.admin.submit');
Route::get('/admin/otp', [AdminLoginController::class, 'showOtpForm'])->name('otp.admin');
Route::post('/admin/otp', [AdminLoginController::class, 'verifyOtp'])->name('otp.admin.verify');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Authenticated User Area
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Messaging / Chat
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanConversationController::class, 'index'])->name('pesan.index');
    Route::post('/pesan/conversations', [PesanConversationController::class, 'store'])->name('pesan.conversations.store');
    Route::get('/pesan/conversations/{conversation}/messages', [PesanConversationController::class, 'messages'])->name('pesan.conversations.messages');
    Route::post('/pesan/conversations/{conversation}/messages', [PesanMessageController::class, 'store'])->name('pesan.messages.store');
    Route::post('/pesan/conversations/{conversation}/read', [PesanMessageController::class, 'markRead'])->name('pesan.conversations.read');

    Route::patch('/pesan/conversations/{conversation}/messages/{message}', [PesanMessageController::class, 'update'])
        ->name('pesan.messages.update');

    Route::delete('/pesan/conversations/{conversation}/messages/{message}', [PesanMessageController::class, 'destroy'])
        ->name('pesan.messages.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin area (single, consolidated group)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // COMMENTS: define specific routes FIRST to avoid being matched by resource parameters
        Route::get('/comments/reported', [AdminCommentController::class, 'reported'])->name('comments.reported');
        Route::get('/comments/latest', [AdminCommentController::class, 'latest'])->name('comments.latest');

        // Notify (modal form sends comment_id in request body)
        Route::post('/comments/notify', [AdminCommentController::class, 'notify'])->name('comments.notify');

        // Resource comments (exclude show because controller doesn't implement show())
        Route::resource('comments', AdminCommentController::class)->except(['show']);

        // Threads
        Route::get('/threads/reported', [AdminThreadController::class, 'reported'])->name('threads.reported');
        Route::post('/threads/notify', [AdminThreadController::class, 'notify'])->name('threads.notify');
        Route::resource('threads', AdminThreadController::class);

        // Users
        Route::resource('users', AdminUserController::class);
        Route::get('/users/{id}/notify', [AdminUserController::class, 'notifyForm'])->name('users.notify');
        Route::post('/users/{id}/notify', [AdminUserController::class, 'sendNotification']);
        Route::patch('/users/{id}/delete-fields', [AdminUserController::class, 'deleteFields'])->name('users.deleteFields');
        Route::post('/users/add-username', [AdminUserController::class, 'addUsername'])->name('users.addUsername');
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Announcements
        Route::resource('announcements', AdminAnnouncementController::class);
        Route::post('/announcements/notify-all', [AdminAnnouncementController::class, 'notifyAll'])->name('announcements.notifyAll');

        // Messages (contact form)
        Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{id}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{id}/reply', [\App\Http\Controllers\Admin\MessageController::class, 'reply'])->name('messages.reply');
        Route::delete('/messages/{id}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');

        // Kalender / Academic Events (admin)
        Route::get('/kalender', [AcademicEventController::class, 'adminIndex'])->name('calendar.index');
        Route::post('/kalender', [AcademicEventController::class, 'store'])->name('calendar.store');
        Route::put('/kalender/{academicEvent}', [AcademicEventController::class, 'update'])->name('calendar.update');
        Route::delete('/kalender/{academicEvent}', [AcademicEventController::class, 'destroy'])->name('calendar.destroy');
        Route::get('/kalender/api', [AcademicEventController::class, 'adminApiIndex'])->name('calendar.api');

        // Activities, settings, reports, stats
        Route::get('activities', [AdminActivityController::class, 'index'])->name('activities.index');
        Route::get('/settings', [AdminSettingsController::class, 'show'])->name('settings.show');
        Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
        Route::get('/reset-password', [AdminSettingsController::class, 'showResetPassword'])->name('reset-password.show');
        Route::put('/reset-password', [AdminSettingsController::class, 'updatePassword'])->name('reset-password.update');

        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::patch('/reports/{id}', [AdminReportController::class, 'update'])->name('reports.update');
        Route::get('/stats', [AdminStatsController::class, 'index'])->name('stats.index');

        // Admin Legal pages (admin versions)
        Route::get('/privacy-policy', [LegalController::class, 'adminPrivacyPolicy'])->name('privacy.policy');
        Route::get('/terms-conditions', [LegalController::class, 'adminTermsAndConditions'])->name('terms.conditions');
    });

/*
|--------------------------------------------------------------------------
| Public profile / misc
|--------------------------------------------------------------------------
*/
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/contact', fn() => view('contact'))->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Notifications (user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

/*
|--------------------------------------------------------------------------
| Other public pages / APIs
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Utilities (email / clear cache)
|--------------------------------------------------------------------------
*/
use Illuminate\Support\Facades\Mail;
Route::get('/test-email', function () {
    Mail::raw('Tes email OTP berhasil', function ($message) {
        $message->to('emailkamu@gmail.com')
                ->subject('Tes Email INNOFORUM');
    });

    return 'Email terkirim';
});

use Illuminate\Support\Facades\Artisan;
Route::get('/__clear', function () {
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');

    return 'CACHE CLEARED';
});
