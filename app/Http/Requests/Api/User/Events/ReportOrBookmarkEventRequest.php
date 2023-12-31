<?php

namespace App\Http\Requests\Api\User\Events;

use Illuminate\Foundation\Http\FormRequest;

class ReportOrBookmarkEventRequest extends FormRequest
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
            'event_id' => 'required|exists:events,id',
            'type' => 'required|in:bookmark,report'
        ];
    }
}
