<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateplaylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Get the playlist ID from the route
        $playlistId = $this->route('id');
        // Find the playlist
        $playlist = \App\Models\Playlist::find($playlistId);
        
        // Check if the playlist exists and the authenticated user owns it
        return $playlist && $playlist->user_id == auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000', // nullable and sometimes are different
            'is_public' => 'sometimes|boolean',
        ];
    }
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'You can only update your own playlists.',
            ], 403)
        );
    }
}
