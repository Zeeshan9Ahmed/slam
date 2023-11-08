<?php

namespace App\Http\Requests\Api\User\Follow;

use Illuminate\Foundation\Http\FormRequest;

class AcceptOrRejectFollowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'follower_id' => 'required|exists:users,id',
            'type' => 'required|in:accept,reject,remove'
        ];
    }
}
