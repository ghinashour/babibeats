<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
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
            'release_date' => 'required|date',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'artist_id' => 'required|exists:artists,id', 
        ];
    }
}
