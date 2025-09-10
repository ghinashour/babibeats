<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
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
            'title' => $this->title,
            'duration' => $this->duration,
            'file_path' => $this->file_path ? asset("storage/{$this->file_path}") : null, // Generates a full URL
            'artist' => new ArtistResource($this->whenLoaded('artist')),
            'album' => new AlbumResource($this->whenLoaded('album')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
