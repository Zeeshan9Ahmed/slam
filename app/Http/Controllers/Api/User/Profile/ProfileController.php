<?php

namespace App\Http\Controllers\Api\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\User\Profile\GetProfileRequest;
use App\Http\Requests\Api\User\Profile\UpdateProfileRequest;
use App\Http\Resources\LoggedInUser;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

class ProfileController extends Controller
{

    public function profile(GetProfileRequest $request)
    {
        $user = User::with('following:id,full_name,avatar',
                            'followers:id,full_name,avatar',
                            'events:id,venue_id,title,location,date,detail,start_time,end_time,event_capacity',
                            'events.images',
                            'events.venue:id,name,image,address,image,lat,lang,capacity,detail',
                            'audio:id,user_id,music_name as title,music_url as url,type,thumbnail',
                            'video:id,user_id,music_name as title,music_url as url,type,thumbnail'
                            )
                        ->select( 'id',
                                  'full_name',
                                   'avatar',
                                   'email',
                                   'role',
                                   'skills',
                                   'social_links',
                                   'bio',
                                   'location',
                                   'phone_number',
                                   'lat',
                                   'lang',
                                )
                        ->selectRaw('(select is_accepted from follows where follower_id = "'.auth()->id().'" AND  
                                        following_id = users.id LIMIT 1 ) as is_following')
                        ->withCount('following','followers','events')
                        ->whereId($request->user_id)->first();
                        $user->skills = $user->skills? explode(',', $user->skills) :[];
                        $user->social_links = $user->social_links ? explode(',', $user->social_links) :[];
                        
        return apiSuccessMessage("Profile Data", $user);
    }
    public function completeProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
    
        if($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/uploadedimages'), $imageName);
            $avatar = asset('uploadedimages')."/".$imageName;
            $user->avatar = $avatar;
        }
        if ($request->full_name){
            $user->full_name = $request->full_name;
        }

        if ($request->skills){
            $user->skills = $request->skills;
        }

        if ($request->bio){
            $user->bio = $request->bio;
        }

        if ($request->phone_number){
            $user->phone_number = $request->phone_number;
        }
        if ($request->lat){
            $user->lat = $request->lat;
        }


        if ($request->lang){
            $user->lang = $request->lang;
        }

        if ($request->location){
            $user->location = $request->location;
        }

        if ($request->social_links){
            $user->social_links = $request->social_links;
        }
        $user->profile_completed = 1;
        // $user->is_active = 1;
        
        if ( $user->save() )
        {
            return apiSuccessMessage("Profile Updated Successfully", new LoggedInUser(auth()->user()));
        }

        return commonErrorMessage("Something went wrong" , 400);
        
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->current_password , $user->password))
        {
            return commonErrorMessage("Current Password is incorrect.",400);
        }

        if (Hash::check($request->new_password , $user->password))
        {
            return commonErrorMessage("Current password and New password can't be same",400);
        } 
        
        $user->password = bcrypt($request->new_password);
        $user->save();
        if( $user )
        {
            return commonSuccessMessage("Password Updated Successfully", 200);
        }
            return commonErrorMessage("Something went wrong while updating old password", 400);
         
    
    }

    public function notifications() 
    {
        $notifications = Notification::with('sender:id,full_name,email,avatar')
                            ->select(
                                'id',
                                'from_user_id',
                                'title',
                                'description',
                                'notification_type',
                                'redirection_id',
                            )
                            ->where('to_user_id', auth()->id())
                            ->when(auth()->user()->role =="user" , function($query){
                                $query->orWhere('to_user_id', 0);
                            })
                            ->latest()->get();
        return apiSuccessMessage("Notifications ", $notifications);
    }
    public function deleteAccount()
    {
        if ( auth()->user()->delete() )
        {
            return commonSuccessMessage("Account Deleted Successfully");
        }
        
    }

    public function notificationToggle()
    {
        $user = auth()->user();
        $message = "";
        if ($user->notification_toggle == 1){
            $user->notification_toggle = 0;
           $message = "Notification turned off";

        }else {
            $user->notification_toggle = 1;
           $message = "Notification turned on";

        }

        $user->save(); 
        return apiSuccessMessage($message, new LoggedInUser($user));
    }
}
