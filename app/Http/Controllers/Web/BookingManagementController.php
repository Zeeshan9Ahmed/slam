<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    public function bookingIndex()
    {
        $venue = Venue::where(['user_id' => auth()->id() ])->first();

        $events = Event::with('artist:id,full_name,avatar')
                        ->where(['status' => 'pending', 'venue_id' => $venue->id])
                        ->get();
        return view('web.bookings.index', compact('events'));
    }
}
