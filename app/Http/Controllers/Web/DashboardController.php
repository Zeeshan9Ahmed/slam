<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard (Request $request) {

        // return $request->session()->get('venue_id');
        $venue = Venue::where(['user_id' => auth()->id() ])->first();

        $count = Event::select(
            DB::raw('(select group_concat(id) from events where venue_id = "'.$venue->id.'" AND status = "approved") as event_ids'),
            DB::raw('(select count(id) from events where venue_id = "'.$venue->id.'" AND status = "approved") as total_events'),
            DB::raw('( select count(id) from event_users as artists where FIND_IN_SET(artists.event_id, event_ids) AND artists.interested = 1 AND type ="artist")as total_artists'),
            DB::raw('( select count(id) from event_users as users where FIND_IN_SET(users.event_id, event_ids) AND users.interested = 1 AND type ="user")as total_users')
        )->first();
        
        return view('web.dashboard' , compact('count'));
    }
}
