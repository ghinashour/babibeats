<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            // Publicly safe information
            'id' => $this->id,
            'name' => $this->name,
            // DO NOT include email, it's sensitive
            // DO NOT include timestamps unless needed

            // Include relationships, but only if they are loaded
            'playlists' => PlaylistResource::collection($this->whenLoaded('playlists')),
            'favorites' => FavoriteResource::collection($this->whenLoaded('favorites')),
            'listening_histories' => ListeningHistoryResource::collection($this->whenLoaded('listeningHistories')),];
    }
}
