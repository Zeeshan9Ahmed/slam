<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Artist\Event\CreateEventRequest;
use App\Http\Requests\Api\User\Artist\GetArtistEventsRequest;
use App\Http\Requests\Api\User\Events\ArtistEventStatus;
use App\Http\Requests\Api\User\Events\DeleteEventImage;
use App\Http\Requests\Api\User\Events\EventDetailRequest;
use App\Http\Requests\Api\User\Events\EventStatusRequest;
use App\Http\Requests\Api\User\Events\GetEventsRequest;
use App\Http\Requests\Api\User\Events\InterestedInEventRequest;
use App\Http\Requests\Api\User\Events\ReportOrBookmarkEventRequest;
use App\Http\Requests\Api\User\Events\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\LoggedInUser;
use App\Models\Event;
use App\Models\EventStatus;
use App\Models\EventUser;
use App\Models\Image;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPUnit\Framework\returnSelf;

class EventController extends Controller
{
    public function events(Request $request)
    {
        $condition = $request->filter_date ? "=" : ">=";
        $date = $request->filter_date ?? Carbon::today();
        $events = Event::has('approved_by_artist')->with('images', 'venue:id,name,address,user_id','venue.user:id,full_name,avatar,email' ,'user_status')
            ->select(
                'id',
                'venue_id',
                'title',
                'location',
                'detail',
                'date',
                'start_time',
                'end_time',
                'created_at',
            )
            ->selectRaw('( select count(*) from event_statuses 
                                        where event_id = events.id and user_id = "' . auth()->id() . '" AND type = "bookmark") as is_bookmarked')
            ->whereRaw(' id NOT IN (select event_id from event_statuses where user_id = "' . auth()->id() . '" AND type ="report") ')
            ->where('date', $condition, $date)
            ->where('status', 'approved')
            ->latest()
            ->get();
        return apiSuccessMessage("Events ", EventResource::collection($events));
    }

    public function interestedInEvent(InterestedInEventRequest $request)
    {
        // return '';
        if ($request->interested == 2 && auth()->user()->role == "user") {
            EventUser::where(['user_id' => auth()->id(), 'event_id' => $request->event_id])->delete();
            return commonSuccessMessage("Success");
        }
        EventUser::updateOrCreate(
            ['user_id' => auth()->id(), 'event_id' => $request->event_id],
            ['interested' => $request->interested]
        );
        return commonSuccessMessage("Success");
    }

    public function reportOrBookmarkEvent(ReportOrBookmarkEventRequest $request)
    {

        $data = $request->validated() + ['user_id' => auth()->id()];
        $event = EventStatus::where($data)->first();


        if (!$event) {
            EventStatus::create($data + ['type' => $request->type]);
            return commonSuccessMessage("Event " . $request->type . "ed Successfully");
        }
        if ($event->type == "report")
            return commonErrorMessage("Already Reported");

        if ($event->type == "bookmark") {
            $event->delete();
            return commonSuccessMessage("Event removed from $request->type Successfully");
        }
    }


    public function eventDetail(EventDetailRequest $request)
    {
        $event = Event::with(
            'images',
            'venue:id,name,address,user_id',
            'venue.user:id,full_name,avatar,email',
            'user_status',
            'attendess',
            'artists',
        )
            ->select(
                'id',
                'venue_id',
                'title',
                'location',
                'detail',
                'date',
                'start_time',
                'end_time',
                'created_at',
            )
            ->selectRaw('( select count(*) from event_statuses 
                                        where event_id = events.id and user_id = "' . auth()->id() . '" AND type = "bookmark") as is_bookmarked')
            ->whereRaw(' id NOT IN (select event_id from event_statuses where user_id = "' . auth()->id() . '" AND type ="report") ')
            ->where('id', $request->event_id)
            ->first();
        // return $event;
        if (!$event)
            return commonErrorMessage("No Event Found");

        return  apiSuccessMessage("Event Detail", new EventResource($event));
    }

    public function getEvents(GetEventsRequest $request)
    {
        $type = $request->type;
        $events = Event::with('images', 'venue:id,name,address,user_id','venue.user:id,full_name,avatar,email', 'user_status')
            ->select(
                'id',
                'venue_id',
                'title',
                'location',
                'detail',
                'date',
                'start_time',
                'end_time',
                'created_at',
            )
            ->selectRaw('( select count(*) from event_statuses 
                                        where event_id = events.id and user_id = "' . auth()->id() . '" AND type = "bookmark") as is_bookmarked')
            ->when($type == "bookmark", function ($query) {
                return $query->whereRaw(' id IN (select event_id from event_statuses where user_id = "' . auth()->id() . '" AND type ="bookmark") ');
            })
            ->when($type == "my_events", function ($query) {
                return $query->whereRaw(' id  IN (select event_id from event_users where user_id = "' . auth()->id() . '" AND interested = 1 AND type ="user") ');
            })
            ->whereRaw(' id NOT IN (select event_id from event_statuses where user_id = "' . auth()->id() . '" AND type ="report") ')
            ->latest()
            ->get();
        return  apiSuccessMessage("Events ", EventResource::collection($events));
    }

    public function eventRequests()
    {
        $events = Event::with('images', 'venue:id,name,address,user_id','venue.user:id,full_name,avatar,email', 'user_status')
            ->select(
                'id',
                'venue_id',
                'title',
                'location',
                'detail',
                'date',
                'event_capacity',
                'start_time',
                'end_time',
                'created_at',
            )
            ->whereRaw(' id IN (select event_id from event_users where user_id = "' . auth()->id() . '" AND type ="artist" AND interested = 0) ')
            ->whereRaw(' id NOT IN (select event_id from event_statuses where user_id = "' . auth()->id() . '" AND type ="report") ')
            ->where('date', ">=", Carbon::today())
            ->latest()
            ->get();
        return apiSuccessMessage("Events ", EventResource::collection($events));
    }

    public function eventStatus(ArtistEventStatus $request)
    {
        $event = EventUser::where(['event_id' => $request->event_id, 'user_id' => auth()->id(), 'type' => 'artist'])
            ->first();
        if (!$event)
            return commonErrorMessage("No Data Found");
        if ($request->type == "accept") {
            if ($event->interested == 1) return commonErrorMessage("Already Accepted");

            $event->update(['interested' => 1]);
            return commonSuccessMessage("Accepted Successfully");
        }
        if ($request->type == "reject") {
            if ($event->interested == 1) return commonErrorMessage("Can't Reject After accepting");
            $event->delete();
            return commonSuccessMessage("Rejected Successfully");
        }
    }

    public function createEvent(CreateEventRequest $request)
    {
        $venue = Venue::find($request->venue_id);
        $venue_start_time = strtotime($venue->start_time);
        $venue_end_time = strtotime($venue->end_time);
        $converted_start_time = strtotime($request->start_time);
        $converted_end_time = strtotime($request->end_time);
        if ( $converted_start_time < $venue_start_time)
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }

        if ( $converted_start_time > $venue_end_time)
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }

        if ( $converted_end_time > $venue_end_time)
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }

        if ( $converted_end_time < $venue_start_time )
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }

        $event = Event::create(
            [
                'venue_id' => $venue->id,
                'title' => $request->title,
                'user_id' => auth()->id(),
                'location' => $venue->address,
                'detail' => $request->detail,
                'date' => $request->date,
                'start_time' => date('h:i A', strtotime($request->start_time)),
                'end_time' => date('h:i A', strtotime($request->end_time)),
                'status' => 'pending',
                'created_by_artist' => 1,
                'event_capacity' => $request->event_capacity,
            ]
        );
        
        EventUser::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'type' => 'artist',
            'interested' => 1
        ]);
        foreach ($request->file('images') ?? [] as $image) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploadedimages'), $imageName);
            $image_url = asset('uploadedimages') . "/" . $imageName;

            $data = new Image([
                'image_url' => $image_url,
            ]);
            $event->images()->save($data);
        }

        return commonSuccessMessage('Event request send successfully');
    }

    public function artistEvents(GetArtistEventsRequest $request)
    {
        $type = $request->type;
        $events = Event::with('images', 'venue:id,name,address,user_id', 'venue.user:id,full_name,avatar,email')
            ->select(
                'id',
                'venue_id',
                'title',
                'location',
                'detail',
                'date',
                'event_capacity',
                'start_time',
                'end_time',
                'created_at',
            )
            ->where('user_id', auth()->id())
            ->when($type == "pending", function ($query) {
                $query->where('status', 'pending');
            })
            ->when($type == "rejected", function ($query) {
                $query->where('status', 'rejected');
            })
            ->when($type == "completed", function ($query) {
                $query->where('status', 'approved')->OrwhereRaw(' id in (select event_id from event_users where user_id = "' . auth()->id() . '" AND interested = 1) and status = "approved"');
            })

            ->latest()
            ->get();
        // ->toSql();
        return apiSuccessMessage("Events", EventResource::collection($events));
    }

    public function updateEvent(UpdateEventRequest $request)
    {
        
        $event = Event::find($request->event_id);
        $venue = Venue::find($event->venue_id);
        $venue_start_time = strtotime($venue->start_time);
        $venue_end_time = strtotime($venue->end_time);
        $converted_start_time = strtotime($request->start_time);
        $converted_end_time = strtotime($request->end_time);
        if ( $converted_start_time < $venue_start_time)
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }

        if ( $converted_start_time > $venue_end_time)
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }

        if ( $converted_end_time > $venue_end_time)
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }

        if ( $converted_end_time < $venue_start_time )
        {
            return commonErrorMessage("Venue is available from $venue->start_time to $venue->end_time ", 200);
        }
        $event->title = $request->title;
        $event->detail = $request->detail;
        $event->date = $request->date;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->event_capacity = $request->event_capacity;
        $event->save();
        foreach ($request->file('images') ?? [] as $image) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploadedimages'), $imageName);
            $image_url = asset('uploadedimages') . "/" . $imageName;

            $data = new Image([
                'image_url' => $image_url,
            ]);
            $event->images()->save($data);
        }

        return commonSuccessMessage("Event Updated");
    }

    public function deleteImage(DeleteEventImage $request)
    {
        $image = Image::find($request->image_id);
        removeFile($image->image_url);
        $image->delete();
        return commonSuccessMessage("Deleted");
        return $request->all();
    }
}
