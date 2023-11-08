<?php

namespace App\Http\Requests\Api\Artist\Music;

use Illuminate\Foundation\Http\FormRequest;

class AddMusicRequest extends FormRequest
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
            'genere_id' => 'required|exists:generes,id',
            'type' => 'required|in:audio,video',
            'music_name' => 'required',
            // 'file' => 'required|file',
        ];
    }
}
