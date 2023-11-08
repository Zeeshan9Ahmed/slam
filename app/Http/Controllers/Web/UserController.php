<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function management(Request $request)
    {
        $venue = Venue::where(['user_id' => auth()->id() ])->first();
        $events = Event::withCount('artists','attendess')->where(['venue_id' => $venue->id, 'status' => 'approved'])->latest()->get();
        // return $events;
        return view('web.user.index', compact('events'));
    }

    public function userProfile($user_id) 
    {
        // dd($user_id);

        $user = User::with('following:id,full_name,avatar',
                            'followers:id,full_name,avatar',
                            'audio:id,user_id,music_name as name,music_url as file,type,thumbnail',
                            'video:id,user_id,music_name as title,music_url as url,type,thumbnail'
                            )
                        ->select( 'id',
                                  'full_name',
                                  'email',
                                   'avatar',
                                   'role',
                                   'skills',
                                   'social_links',
                                   'bio',
                                   'location',
                                   'phone_number'
                                )
                        ->withCount('following','followers')
                        ->whereId($user_id)->first();
        // return $user;
        return view('web.user.user_profile', compact('user'));

    }
}
