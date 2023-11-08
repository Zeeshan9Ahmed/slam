<?php

use App\Http\Controllers\Api\Artist\Music\MusicController;
use App\Http\Controllers\Api\Artist\Venue\VenueController;
use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\PasswordController;
use App\Http\Controllers\Api\User\Auth\SignUpController;
use App\Http\Controllers\Api\User\Core\IndexController;
use App\Http\Controllers\Api\User\EventController;
use App\Http\Controllers\Api\User\Follow\FollowController;
use App\Http\Controllers\Api\User\Friend\FriendController;
use App\Http\Controllers\Api\User\OTP\VerificationController;
use App\Http\Controllers\Api\User\Profile\ProfileController;
use App\Http\Controllers\Api\User\Search\SearchController;
use App\Http\Controllers\CommonChatController;
use App\Http\Controllers\Web\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', function () {
    return response()->json(["status"=>0,"message"=>"Sorry User is Unauthorize"], 401);
})->name('login');

Route::post('signup', [SignUpController::class, 'signUp']);
Route::post('signup/resend-otp', [SignUpController::class, 'resendSignUpOtp']);

Route::post('otp-verify', [VerificationController::class, 'otpVerify']);

Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [PasswordController::class, 'forgotPassword']);
Route::post('reset/forgot-password', [PasswordController::class, 'resetForgotPassword']);
Route::get('content', [IndexController::class, 'content']);
Route::post('social', [LoginController::class, 'socialAuth']);


Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('change-password', [ProfileController::class , 'changePassword']);
    Route::post('update-profile', [ProfileController::class , 'completeProfile']);
    Route::get('profile', [ProfileController::class , 'profile']);
    Route::get('notifications', [ProfileController::class , 'notifications']);
    Route::post('notification-toggle', [ProfileController::class , 'notificationToggle']);


    Route::delete('delete-account', [ProfileController::class , 'deleteAccount']);

    Route::post('follow-unfollow-user',[FollowController::class, 'followUnFollowUser']);
    Route::post('follow-request',[FollowController::class, 'acceptOrRejectFollowRequest']);
    Route::get('users-list',[FollowController::class, 'getUsersList']);
    Route::post('remove-follower',[FollowController::class, 'removeFollower']);
    
    Route::get('events', [EventController::class , 'events']);
    Route::get('event-detail', [EventController::class , 'eventDetail']);
    Route::get('get-events', [EventController::class , 'getEvents']);
    Route::post('interested-in-event', [EventController::class , 'interestedInEvent']);
    Route::post('report-bookmark-event', [EventController::class , 'reportOrBookmarkEvent']);

    Route::get('search', [SearchController::class,'search']);

    Route::get('music-search', [SearchController::class,'searchMusic']);

    Route::get('chat-list', [CommonChatController::class,'chatList']);
    Route::get('search-chat', [CommonChatController::class,'searchChat']);
    
    Route::post('message/uploadimage', [MessageController::class, 'uploadImage']);
    
    
    Route::get('media', [MusicController::class,'media']);

    
    Route::group(['prefix' => 'artist'],function(){
        Route::get('generes', [MusicController::class,'getGeneres']);
        Route::post('add-music', [MusicController::class,'addMusic']);

        Route::get('event-requests', [EventController::class,'eventRequests']);
        Route::get('events', [EventController::class,'artistEvents']);
        Route::post('event-status', [EventController::class,'eventStatus']);
        Route::post('event', [EventController::class,'createEvent']);
        Route::post('update-event', [EventController::class,'updateEvent']);
        Route::get('event/delete-image', [EventController::class,'deleteImage']);

        Route::get('venue/booked-dates', [VenueController::class,'venueBookedDates']);
        Route::get('venue-detail', [VenueController::class,'venueDetail']);
        Route::get('venues', [VenueController::class,'artistVenues']);
        Route::get('search', [VenueController::class,'searchEventOrVenue']);
    });
    Route::post('logout', [LoginController::class , 'logout']);


    // Route::post('send-request',[FriendController::class, 'sendRequest']);
    // Route::post('accept-request',[FriendController::class, 'acceptRequest']);
    // Route::post('cancel-request',[FriendController::class, 'cancelRequest']);
    // Route::post('reject-request',[FriendController::class, 'rejectRequest']);
    // Route::post('unfriend',[FriendController::class, 'unFriend']);
    // Route::get('friend-list',[FriendController::class, 'friendList']);
    // Route::get('search-user',[FriendController::class, 'searchUser']);
    
});