<?php

namespace App\Http\Requests\Api\Artist\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'venue_id' => 'required|exists:venues,id',
            'title' => 'required',
            'detail' => 'required',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
            'event_capacity' => 'required',
        ];
        // |after:start_time
    }
}
