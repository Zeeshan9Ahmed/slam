<?php

namespace App\Http\Requests\Api\Artist\Venue;

use Illuminate\Foundation\Http\FormRequest;

class VenueBookedDatesRequest extends FormRequest
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
            'venue_id' => 'required|exists:venues,id'
        ];
    }
}
