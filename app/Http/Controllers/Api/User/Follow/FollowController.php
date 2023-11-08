<?php

namespace App\Http\Controllers\Api\User\Follow;

use App\Events\AcceptOrRejectFollowRequestEvent;
use App\Events\FollowUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Follow\AcceptOrRejectFollowRequest;
use App\Http\Requests\Api\User\Follow\FollowingFollowersListRequest;
use App\Http\Requests\Api\User\Follow\RemoveFollowerRequest;
use App\Http\Requests\Api\User\FollowUnfollowRequest;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class FollowController extends Controller
{
    public function followUnFollowUser(FollowUnfollowRequest $request)
    {
        $following_id = $request->following_id;

        if (auth()->id() == $following_id) {
            return commonErrorMessage("Can Not Follow Ur Self", 400);
        }

        $user = User::find($following_id);

        if (!$user) {
            return commonErrorMessage("Can not follow User Does not exists", 404);
        }
        // if($user->is_verified == 0){
        //     return commonErrorMessage("User Account is not verified",404);
        // }
        // if($user->is_blocked == 1){
        //     return commonErrorMessage("User is Blocked",404);
        // }

        $data = [
            'follower_id' => auth()->id(),
            'following_id' => $following_id
        ];

        $follow = Follow::where($data)->first();
        if (!$follow) {
            if ($user->notification_toggle == 1){

                event(new FollowUserEvent($user));
            }
            $following = Follow::create($data);
            // return apiSuccessMessage("Followed Successfully",new UserResource(User::logged_in_user()));
            return commonSuccessMessage("Followed Successfully", 200);
        }

        $unfollowing = $follow->delete();
        if ($unfollowing) {
            // return apiSuccessMessage("UnFollowed Successfully",new UserResource(User::logged_in_user()));

            return commonSuccessMessage("UnFollowed Successfully", 200);
        }
    }


    public function getUsersList(FollowingFollowersListRequest $request)
    {
        $user = User::
                    with('followers:id,full_name,avatar,role','following:id,full_name,avatar,role','pending_requests:id,full_name,avatar,role')
            ->whereId($request->user_id)->first();
        $users = [];
        if ( $request->type =="following"){
            $users = $user->following;
        }

        if ( $request->type =="followers"){
            $users = $user->followers;
        }
        if ( $request->type =="pending"){
            $users = $user->pending_requests;
        }
        return apiSuccessMessage("Success", $users);
    }

    public function acceptOrRejectFollowRequest(AcceptOrRejectFollowRequest $request)
    {

        $type = $request->type;
        $data = [
            'follower_id' => $request->follower_id,
            'following_id' => auth()->id()
        ];
        $follow = Follow::where($data)->first();

        if (!$follow)
            return commonErrorMessage("No Request");
        $recipient = User::find($request->follower_id);
        if ($type == "accept") {
            if ($follow->is_accepted == 1) {
                return commonErrorMessage("Request Already Accepted");
            }

            $follow->is_accepted = 1;
            $follow->save();
            if ($recipient->notification_toggle == 1)
            {
                event(new AcceptOrRejectFollowRequestEvent($recipient , $type));
            }


            return commonSuccessMessage("Request Accepted Successfully");
        }

        if ($type == "reject") {
            $follow->delete();
            if ($recipient->notification_toggle == 1)
            {
                // event(new AcceptOrRejectFollowRequestEvent($recipient , $type));
            }

            return commonSuccessMessage("Request Rejected Successfully");
        }

        if ($type == "remove") {
            $follow->delete();
            return commonSuccessMessage("Removed Successfully");
        }

        
    }

    public function removeFollower(RemoveFollowerRequest $request) 
    {
        $follower = Follow::where(['follower_id' => $request->follower_id , 'following_id' => auth()->id(),'is_accepted' => 1])->first();

        if (!$follower)
            return commonErrorMessage("Invalid Follower Id");

        $follower->delete();
        return commonSuccessMessage("Success");
        
    }
}
