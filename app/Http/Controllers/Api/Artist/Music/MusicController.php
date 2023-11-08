<?php

namespace App\Http\Controllers\Api\Artist\Music;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Artist\Music\AddMusicRequest;
use App\Models\Genere;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MusicController extends Controller
{
    public function getGeneres()
    {
        $generes = Genere::get(['id','name','image']);
        return  apiSuccessMessage("Genres", $generes);
    }

    public function addMusic(AddMusicRequest $request)
    {
        
        $type = $request->type;
        if ($type == "video"){
            $this->validate($request,[
                'file' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
             ]);
        }

        if ($type == "audio"){
            $this->validate($request,[
                'file' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'
             ]);
        }
        $file = "";
        if($request->hasFile('file')){
            $uuid = Str::uuid();
            $imageName = $uuid .time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('/uploadedfiles'), $imageName);
            $file = asset('uploadedfiles')."/".$imageName;
            
        }
        $thumbnail = "";
        if($request->hasFile('thumbnail')){
            $uuid = Str::uuid();
            $imageName = $uuid .time().'.'.$request->thumbnail->getClientOriginalExtension();
            $request->thumbnail->move(public_path('/uploadedfiles'), $imageName);
            $thumbnail = asset('uploadedfiles')."/".$imageName;
            
        }

        Music::create([
            'user_id' => auth()->id(),
            'genere_id' => $request->genere_id,
            'music_name' => $request->music_name,
            'music_url' => $file,
            'type' => $type,
            'thumbnail' => $thumbnail,
        ]);
        return commonSuccessMessage("Added Successfully");
    }

    public function media() 
    {
        $media = Music::with('artist:id,full_name,avatar','genere:id,name,image')->latest()->get(['id','music_name as title','music_url as url','type','thumbnail','genere_id','user_id']);
        
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
                       'artist' => $song->artist,
                    ];
                }),
            ];
        });
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
        $data = [
            'all' => $media,
            'artits' => $artists,
            'generes' => $generes,
        ];

        return apiSuccessMessage("Media ", $data);
    }
}
