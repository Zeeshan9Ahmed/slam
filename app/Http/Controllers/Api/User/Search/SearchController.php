<?php

namespace App\Http\Controllers\Api\User\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Music\SearchMusicRequest;
use App\Http\Requests\Api\User\Search\SearchRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventUserResource;
use App\Models\Event;
use App\Models\Music;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    public function search(SearchRequest $request)
    {
        $type = $request->type;
        $key_word = $request->key_word;
        $filter_date = $request->filter_date;

        if ($type == 'events') {
            return apiSuccessMessage("Events ", EventResource::collection($this->searchEvents($key_word , $filter_date)));
        }

        if ($type == 'event') {
            $event_id = $request->event_id;
            $event = $this->SearchUsersInEvent($event_id, $key_word);
            if (!$event)
                return commonErrorMessage("No Event");
            return apiSuccessMessage("Users ", EventUserResource::collection($event->attendess));
        }

        // if ($type == 'chat') {
        // }
        
    }
    public function searchMusic(SearchMusicRequest $request)
    {
        // return $request->all();
        $search = $request->key_word;
        $type = $request->type;

        if ($type == 'all' ){
            return apiSuccessMessage("Success", $this->searchAllMusic($search));
        }

        if ($type == 'genere' ){
            return apiSuccessMessage("Success", $this->searchGenere($search));
        }

        if ($type == 'artist' )
        {
            return apiSuccessMessage("Success", $this->searchArtist($search));
        }
    }

    public function searchAllMusic($search)
    {
        return Music::join('generes', 'genere_id', 'generes.id')
            ->join('users', 'user_id', 'users.id')
            ->with('artist', 'genere')
            ->select(
                'music.id',
                'music_name as title',
                'music_url as url',
                'type',
                'thumbnail',
                'genere_id',
                'user_id'
            )
            ->where('music_name', 'LIKE', "%$search%")
            ->orWhere('generes.name', 'LIKE', "%$search%")
            ->orWhere('users.full_name', 'LIKE', "%$search%")
            // ->groupBy('id')
            ->latest('music.created_at')
            ->get();

           
    }

    public function searchGenere($search)
    {
        $media = Music::join('generes', 'genere_id', 'generes.id')
            ->join('users', 'user_id', 'users.id')
            ->with('artist', 'genere')
            ->select(
                'music.id',
                'music_name as title',
                'music_url as url',
                'type',
                'thumbnail',
                'genere_id',
                'user_id'
            )
            ->where('generes.name', 'LIKE', "%$search%")
            // ->groupBy('id')
            ->latest('music.created_at')
            ->get();

            $generes = $media->groupBy('genere_id')->values()->map(function ($genere){
                return [
                    'genere' => $genere->first()->genere,
                    'audio_count' => $genere->where('type', 'audio')->count(),
                    'video_count' => $genere->where('type', 'video')->count(),
                    'songs' => $genere->map(function ($song){
                        return [
                           'id' => $song->id,
                           'title' => $song->title,
                           'url' => $song->url,
                           'type' => $song->type,
                           'thumbnail' => $song->thumbnail,
                        ];
                    }),
                ];
            });
            return $generes;

            
    }

    public function searchArtist($search)
    {
        $media = Music::join('generes', 'genere_id', 'generes.id')
            ->join('users', 'user_id', 'users.id')
            ->with('artist', 'genere')
            ->select(
                'music.id',
                'music_name as title',
                'music_url as url',
                'type',
                'thumbnail',
                'genere_id',
                'user_id'
            )
            ->where('users.full_name', 'LIKE', "%$search%")
            // ->groupBy('id')
            ->latest('music.created_at')
            ->get();

            $artists = $media->groupBy('user_id')->values()->map(function ($data, $key){
                $artist = $data->first()->artist;
                return [
                    'audio_count' => $data->where('type', 'audio')->count(),
                    'video_count' => $data->where('type', 'video')->count(),
                    'artist_name' => [
                        'id'=> $artist->id??"",
                        'full_name'=> $artist->full_name??"",
                        'avatar'=> $artist->avatar??""
                    ],
                    'songs' => $data->map(function ($song){
                        return [
                           'id' => $song->id,
                           'title' => $song->title,
                           'url' => $song->url,
                           'type' => $song->type,
                           'thumbnail' => $song->thumbnail,
                           'genere' => $song->genere
                        ];
                    }),
                ];
            });
            return $artists;
    }
    public function searchEvents($search, $filter_date = null)
    {
        $condition = $filter_date ? "=" : ">=";
        $date = $filter_date ?? "";
        
        $events = Event::has('approved_by_artist')
        ->with('images', 'venue:id,name,address', 'user_status')
        ->join('venues','events.venue_id','venues.id')
            ->select(
                'events.id',
                'venue_id',
                'title',
                'location',
                'events.detail',
                'date',
                'events.start_time',
                'events.end_time',
                'events.created_at',
            )
            ->where('status', 'approved')
            ->where('date', $condition, $date)
            ->where('title', 'LIKE', '%' . $search . '%')
            ->Orwhere('events.detail', 'LIKE', '%' . $search . '%')
            ->Orwhere('venues.name', 'LIKE', '%' . $search . '%')
            ->selectRaw('( select count(*) from event_statuses 
                                        where event_id = events.id and user_id = "' . auth()->id() . '" AND type = "bookmark") as is_bookmarked')
            ->whereRaw(' events.id NOT IN (select event_id from event_statuses where user_id = "' . auth()->id() . '" AND type ="report") ')
            ->latest()
            ->get();
        return $events;
        
    }

    public function SearchUsersInEvent($event_id, $search)
    {
        $event = Event::with(
                ['attendess' => function ($query) use ($search) {
                    $query->where('full_name', 'LIKE', "%$search%")->where('users.id', '!=', auth()->id());
                }]
            )
            ->select(
                'id',
            )
            ->whereRaw('events.id NOT IN (select event_id from event_statuses where user_id = "' . auth()->id() . '" AND type ="report") ')
            ->where('events.id', $event_id)
            ->first();


        return $event;
    }
}
