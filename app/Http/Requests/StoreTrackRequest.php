<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         return auth()->check();;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'file' => 'required|file|mimes:mp3,wav,aac|max:10240', // 10MB max, audio types
            'artist_id' => 'required|exists:artists,id',
            'album_id' => 'nullable|exists:albums,id',
        ];
    }
    
    public function messages(): array
    {
        return [
            'file.mimes' => 'The audio file must be in MP3, WAV, or AAC format.',
            'file.max' => 'The audio file must not be larger than 10MB.',
        ];
    }
}
