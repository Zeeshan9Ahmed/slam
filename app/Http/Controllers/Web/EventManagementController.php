<?php

namespace App\Http\Controllers\Web;

use App\Events\ApproveEvent;
use App\Events\NewEventCreateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Events\DeleteEventImage;
use App\Models\Event;
use App\Models\EventStatus;
use App\Models\EventUser;
use App\Models\Image;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventManagementController extends Controller
{
    public function management()
    {
        $artists = User::where('role','artist')->get(['id','full_name','avatar']);
        $venue = Venue::where(['user_id' => auth()->id() ])->first();
        $events = Event::with('artist_status.user')->where(['venue_id' => $venue->id, 'status' => 'approved'])->latest()->get();
        // return $events;

        return view('web.event.index' , compact('artists','events','venue'));
    }

    public function createEvent(Request $request)
    {
        // dd($request->all());
        $venue = Venue::where('user_id', auth()->id())->first();
        
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
                'status' => 'approved', 
                'created_by_artist' => 0, 
                'event_capacity' => $request->event_capacity, 
            ]
        );

        EventUser::create([
            'user_id' => $request->user_id,
            'event_id' => $event->id,
            'type' => 'artist',
            'interested' => 0
        ]);
        foreach ($request->file('files') ?? [] as $image) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploadedimages'), $imageName);
            $image_url = asset('uploadedimages') . "/" . $imageName;

            $data = new Image([
                'image_url' => $image_url,
            ]);
            $event->images()->save($data);
            
        }

        $message = "New event created by $venue->name";

        $author = User::find($request->user_id);
        // $author->token;
        $author_data = [
            'device_token' => $author->device_token,
            'author_id' => $author->id,
            'is_notification_on' => $author->notification_toggle,
        ];
        event(new NewEventCreateEvent($message ,$event->id, $author_data));
        
        return redirect()->back()->with('success', 'Event Created Successfully');
    }

    public function eventDetail(Request $request)
    {
        $event = Event::with('artist_status.user','images')->where('id', $request->event_id)->first();
        return webapiSuccessMessage("success", $event);
    }

    public function approveReportedEvent(Request $request)
    {
        
        $event_id = $request->event_id;
        EventUser::where(['event_id' => $event_id])->delete();
        
        EventStatus::where(['event_id' => $event_id])->delete();
        $images = Image::where(['imageable_id' => $request->event_id]);
        foreach ($images->pluck('image_url') as $image)
        {
            removeFile($image);
        }
        $images->delete();
        Event::whereId($event_id)->delete();
        return webcommonSuccessMessage("success");
    }

    public function rejectReportedEvent(Request $request)
    {
        $event_id = $request->event_id;
        EventStatus::where(['event_id' => $event_id])->delete();
        return webcommonSuccessMessage("success");
    }


    public function approveRejectEvent(Request $request)
    {
        $event = Event::find($request->event_id);
        $venue = Venue::where('user_id', auth()->id())->first();
        $user = User::find($event->user_id);
        if ($request->type == "approve")
        {
            $event->status = 'approved';

            $event->save();
            EventUser::where(['event_id' => $event->id , 'user_id' => $user->id])->update(['interested' => 1]);
            $message = $venue->name ." approved your event request";
            $type = "APPROVE_EVENT";
            // $message = " Your $event->title has been approved";
            if ($user->notification_toggle == 1){

                event(new ApproveEvent($event, $message, $type , $user));
            }
        }

        if ($request->type == "reject")
        {
            $message = $venue->name ." rejected your event request";
            $type = "REJECT_EVENT";

            $event->status = 'rejected';
            $event->save();
        }
        return webcommonSuccessMessage("success");

        
    }
    public function reportedEvents() 
    {
        
        $venue = Venue::where('user_id', auth()->id())->first();
        $event_ids = Event::where('venue_id', $venue->id)->pluck('id');
        $reported_events = EventStatus::with('events.reported_users')->whereIn('event_id', $event_ids)->where('type','report')->get()->unique('event_id');
        return view('web.event.reported_events' , compact('reported_events'));
        
    }

    public function updateEvent(Request $request) 
    {
        // dd($request->all());
        $event = Event::findOrFail($request->id);
        $event->id = $request->id;
        $event->title = $request->title;
        $event->event_capacity = $request->event_capacity;
        $event->detail = $request->detail;
        $event->date = $request->date;
        $event->start_time = date('h:i A', strtotime($request->start_time));
        $event->end_time = date('h:i A', strtotime($request->end_time));

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

        if ($request->user_id){
        $user = EventUser::updateOrCreate(
            ['event_id' => $event->id , 'type' => 'artist'],
            ['user_id' => $request->user_id ]
        );
         }
        // $event_artist =EventUser::where(['event_id' => $event->id , 'type' => 'artist'])->first();
        // $event_artist->user_id = $request->user_id;
        // $event_artist->save();
        return redirect()->back()->with('success', 'Event Updated Successfully');
    }

    public function eventUsers($event_id) 
    {
        $users =  Event::with('users_list')->whereId($event_id)->firstOrFail();
      
        return view('web.user.user_details', compact('users'));

    }

    public function deleteEvent(Request $request)
    {
        $event_id = $request->event_id;
        EventUser::where(['event_id' => $event_id])->delete();
        
        EventStatus::where(['event_id' => $event_id])->delete();
        $images = Image::where(['imageable_id' => $request->event_id]);
        foreach ($images->pluck('image_url') as $image)
        {
            removeFile($image);
        }
        $images->delete();
        Event::whereId($event_id)->delete();
        return webcommonSuccessMessage("success");


    }

    public function deleteImage(Request $request)
    {
        $image = Image::find($request->image_id);
        removeFile($image->image_url);
        $image->delete();
        return commonSuccessMessage("Deleted");
        return $request->all();
    }
}
