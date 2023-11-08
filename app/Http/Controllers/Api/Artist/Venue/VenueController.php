<?php

namespace App\Http\Controllers\Api\Artist\Venue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Artist\Venue\VenueBookedDatesRequest;
use App\Http\Requests\Api\User\Events\SearchEventOrVenueRequest;
use App\Models\Event;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenueController extends Controller
{
    public function venueBookedDates(VenueBookedDatesRequest $request)
    {
        $dates = Event::where('venue_id', $request->venue_id)
            ->where('date', '>=', Carbon::today())
            ->where('status', 'approved')
            ->orderBy('date')->pluck('date');
        return apiSuccessMessage("Dates", $dates);
    }
    public function venueDetail(VenueBookedDatesRequest $request) 
    {
        $venue = Venue::with('user:id,full_name,avatar,email')->whereId($request->venue_id)->first();
        return apiSuccessMessage("Venue", $venue);
    }

    public function artistVenues(Request $request)
    {
        $venues = Venue::with('user:id,full_name,avatar,email')->select('*')
                    ->selectRaw("( 3956 * acos( cos( radians(?) ) *
                                    cos( radians( lat ) )
                                    * cos( radians( lang ) - radians(?)
                                    ) + sin( radians(?) ) *
                                    sin( radians( lat ) ) )
                                ) AS distance", [$request->lat, $request->lang, $request->lat])
                    ->having("distance", "<", 5)
                    ->latest()
                    ->get();
        return apiSuccessMessage("Venues" , $venues);
    }

    public function searchEventOrVenue(SearchEventOrVenueRequest $request) 
    {
        $key_word = $request->key_word;
        $search = DB::select('(SELECT id , name as title, detail,"venue" as type,image FROM venues 
                                WHERE name LIKE "%'.$key_word.'%" OR detail LIKE "%'.$key_word.'%" ) 
                            UNION ALL
                            (SELECT id , full_name as title,"" as detail,role as type, avatar as image FROM users 
                                WHERE (full_name LIKE "%'.$key_word.'%") AND role IN ("user","artist")  AND users.id != '.auth()->id().')                   
                            UNION ALL
                            (SELECT id ,  title, detail,"event" as type, (select image_url from images WHERE imageable_id = events.id LIMIT 1) FROM events 
                                WHERE title LIKE "%'.$key_word.'%" OR detail LIKE "%'.$key_word.'%" )
                            ');
        return $search;
    }
}
