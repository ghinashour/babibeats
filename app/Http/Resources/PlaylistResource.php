<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaylistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_public' => (bool) $this->is_public, // Ensure it's a boolean, not "yes"/"no"
            'track_count' => $this->tracks_count, // Useful field to add
            // Do not include user_id unless necessary for a public API
        ]
    }
}
