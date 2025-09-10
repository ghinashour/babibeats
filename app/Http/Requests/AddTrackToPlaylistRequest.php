<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTrackToPlaylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $playlistId = $this->route('id');
        $playlist = Playlist::find($playlistId);
        
        // Check if the user owns the playlist they are trying to modify
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
            //
        ];
    }
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'You can only modify your own playlists.',
            ], 403)
        );
    }
}
