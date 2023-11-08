<?php

use App\Http\Controllers\Api\User\Auth\PasswordController;
use App\Http\Controllers\Api\User\OTP\VerificationController;
use App\Http\Controllers\Api\User\Profile\ProfileController;
use App\Http\Controllers\Web\BookingManagementController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EventManagementController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\SignUpController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    
    Route::get('venue/logout', [SignUpController::class, 'logout']);
    
    Route::group(['middleware' => ['is_venue_admin','prevent-back-history']], function () {
        Route::get('venue/profile-setup', [SignUpController::class, 'profileSetupForm'])->name('venue_profile_setup');
        Route::post('venue/update-profile', [SignUpController::class, 'updateProfile']);
        
        Route::group(['middleware' => ['is_venue_profile_completed']], function () {

        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('venue_dashboard');
        });

        Route::controller(SettingController::class)->group(function () {
            Route::get('/settings', 'setting');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('/users-management', 'management');
            Route::get('/user/{id}', 'userProfile');
        });

        Route::controller(EventManagementController::class)->group(function () {
            Route::get('/events-management', 'management');
            Route::post('/create-event', 'createEvent')->name('create_event');
            Route::get('/event-detail', 'eventDetail');
        });

        Route::get('booking-management', [BookingManagementController::class, 'bookingIndex']);

        Route::post('approve-reject/event', [EventManagementController::class, 'approveRejectEvent']);
        Route::post('approve-reported/event', [EventManagementController::class, 'approveReportedEvent']);
        Route::post('reject-reported/event', [EventManagementController::class, 'rejectReportedEvent']);
        Route::post('event-update', [EventManagementController::class, 'updateEvent']);
        
        Route::get('reported-events', [EventManagementController::class, 'reportedEvents']);

        Route::get('event/{id}', [EventManagementController::class, 'eventUsers']);
        Route::get('delete-event', [EventManagementController::class, 'deleteEvent']);

        Route::get('delete-image', [EventManagementController::class,'deleteImage']);


        // Route::get('venue/profile-setup', [SignUpController::class, 'profileSetupForm'])->name('venue_profile_setup');
        
        // Route::get('venue/complete-profile', [SignUpController::class, 'completeProfileForm']);

        Route::get('messages/{user_id?}', [MessageController::class, 'getMessages']);
        Route::post('message/uploadimage', [MessageController::class, 'uploadImage']);


        Route::post('change-password', [ProfileController::class , 'changePassword']);

    });


});

    Route::post('venue/otp-verify', [SignUpController::class, 'otpVerify']);

    Route::post('venue/forgot-password', [SignUpController::class, 'forgotPassword']);

    Route::post('venue/signup/resend-otp', [SignUpController::class, 'resendSignUpOtp']);

    Route::get('venue/change-password', [SignUpController::class, 'changePasswordForm']);
    Route::post('venue/change-password', [SignUpController::class, 'resetForgotPassword']);

    Route::get('venue/signup', [SignUpController::class, 'signUpForm']);
    Route::post('venue/signup', [SignUpController::class, 'signUp']);


    Route::get('venue/login', [SignUpController::class, 'loginForm'])->name('venue_login');
    Route::post('venue/login', [SignUpController::class, 'login']);
    Route::get('venue/forgot-password', [SignUpController::class, 'forgotPasswordForm']);
    Route::get('venue/otp', [SignUpController::class, 'otpForm']);
   
});
