<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\CommonChatController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public $chat;
    public function __construct(CommonChatController $chat)
    {
        $this->chat = $chat;
    }
    public function getMessages($user_id = null)
    {


        $chat_list = $this->chat->chat(auth()->id());
        // return $chat_list;
        $user = "";
        if ($user_id) {

            $user = User::find($user_id);
        }
        // $chat_list = [];
        return view('web.messages.index', compact('chat_list', 'user_id', 'user'));
    }

    public function uploadImage(Request $request)
    {
        // dd($request->all());
        // return $request->all();
        $imageName = "";
        if ($request->hasFile('avatar')) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/uploadedimages'), $imageName);
            // $imageName;

        }
        return apiSuccessMessage("Image Uploaded",['imageName' => "uploadedimages"."/".$imageName]);
    }
}
