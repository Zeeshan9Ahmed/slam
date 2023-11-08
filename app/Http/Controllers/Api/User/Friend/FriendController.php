<?php

namespace App\Http\Controllers\Api\User\Friend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Friend\AcceptFriendRequestRequest;
use App\Http\Requests\Api\User\Friend\RejectFriendRequestRequest;
use App\Http\Requests\Api\User\Friend\SendFriendRequestRequest;
use App\Http\Requests\Api\User\Friend\UnfriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{

    public function sendRequest(SendFriendRequestRequest $request)
    {
        $recipient_id = $request->recipient_id;
        $user = Auth::user();
        if($recipient_id == auth()->id()){
            return commonErrorMessage("Sender ANd Reciever can not be same",400);
        }
        
        $recipient = User::find($recipient_id);
        
        if(!$recipient){
            return commonErrorMessage("Invalid recipient Id, User Not Found",404);
        }
        // if($recipient->is_verified == 0){
        //     return commonErrorMessage("User Account is not verified",400);  
        // }
        
        $send_request = $user->sendRequest($recipient);
        
        if($send_request){
            // event(new SendFriendRequestEvent($recipient,$user));
            return commonSuccessMessage("Freind Request Sent Successfully",200);
        }
        return commonErrorMessage("Request Failed ",400);
    }
    public function acceptRequest(AcceptFriendRequestRequest $request)
    {
        $recipient_id = $request->recipient_id;

        $user = Auth::user();
        
        if(auth()->id() == $recipient_id)
        {
            return commonErrorMessage("Sender can not be accepter",400);
        }

        $recipient = User::find($recipient_id);
        
        if(!isset($recipient)){
            return commonErrorMessage("Invalid Sender iD",400);
        }
        $request_accepted = $user->acceptRequest($recipient);
        
        if($request_accepted)
        {
            // $this->makeFollowAndFollowing($recipient_id);    
        //   event(new AcceptFriendRequestEvent( $recipient , $user ));
        //   return apiSuccessMessage("request Accepted",new UserResource(User::logged_in_user()));
          return commonSuccessMessage("request Accepted");
        }
        
        return commonErrorMessage("Failed To accept the request",400);
    }
    public function cancelRequest()
    {
        return 'hehehehehhehe';
    }

    public function rejectRequest(RejectFriendRequestRequest $request)
    {
        $recipient_id = $request->recipient_id;
        
        $user = Auth::user();
        $recipient = User::find($recipient_id);
        
        if(!isset($recipient)){
            return commonErrorMessage("Invalid Sender iD",400);
        }

        $request_rejected = $user->denyRequest($recipient);
        if($request_rejected){
            $request_rejected->delete();
            return commonSuccessMessage("Request Rejected Successfully");
        }
        
        return commonErrorMessage("Failed to reject the request",400);
        
    }

    public function unFriend(UnfriendRequest $request)
    {
        $recipient = User::find($request->recipient_id);
        if(!$recipient){
            return commonErrorMessage("Invalid Recipeint",400);
        }
        $user = Auth::user();
        
        $unfriend = $user->unfriend($recipient);
        if($unfriend)
        {
            // $this->removeFromFollowAndFollowingList($recipient->id);
        //   event(new RejectFriendRequestEvent( $recipient , $user ));
        //   return apiSuccessMessage("User Unfriend",new UserResource(User::logged_in_user()));

            return commonSuccessMessage("User Unfriend");
        }
        return commonErrorMessage("Failed To unfriend",400);
    }


}
