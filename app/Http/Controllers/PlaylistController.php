<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Http\Requests\AddTrackToPlaylistRequest;
// You need to create this Request class:
// use App\Http\Requests\RemoveTrackFromPlaylistRequest;

use Illuminate\Http\JsonResponse;

class PlaylistController extends Controller
{
     public function index()
    {
        return Playlist::with('user')->get();
    }

    public function show(Playlist $playlist)
    {
        return $playlist->load(['user', 'tracks']);
    }


    public function store(StorePlaylistRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $playlist = $request->user()->playlists()->create($validated);

        return response()->json([
            'message' => 'Playlist created successfully.',
            'data' => $playlist->load('tracks')
        ], 201);
    }

    // FIXED: Changed parameter from 'string $id' to 'Playlist $playlist'
    public function update(UpdatePlaylistRequest $request, Playlist $playlist): JsonResponse
    {
        // The UpdatePlaylistRequest handles authorization and validation
        $playlist->update($request->validated());

        return response()->json([
            'message' => 'Playlist updated successfully.',
            'data' => $playlist->fresh()
        ]);
    } 

    // FIXED: Changed parameter from 'string $id' to 'Playlist $playlist'
    public function destroy(Playlist $playlist): JsonResponse
    {
        // Find the playlist (No longer needed, $playlist is already injected)
        // $playlist = Playlist::findOrFail($id);

        // Authorize: Check if the user owns the playlist
        // NOTE: This logic should ideally be inside a Form Request like UpdatePlaylistRequest
        if ($playlist->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'You can only delete your own playlists.',
            ], 403);
        }

        $playlist->delete();

        return response()->json([
            'message' => 'Playlist deleted successfully.',
        ], 200);
    }

    public function addTrack(AddTrackToPlaylistRequest $request, Playlist $playlist): JsonResponse
    {
        // The AddTrackToPlaylistRequest authorizes the user and validates 'track_id'
        $trackId = $request->input('track_id');

        // Check for duplicate track
        if ($playlist->tracks()->where('track_id', $trackId)->exists()) {
            return response()->json(['message' => 'Track already in playlist'], 409);
        }

        // Add the track with a position
        $playlist->tracks()->attach($trackId, [
            'position' => $playlist->tracks()->count() + 1,
        ]);

        return response()->json([
            'message' => 'Track added to playlist.',
            'data' => $playlist->fresh('tracks')
        ]);
    }

    // FIXED: Changed the Request class parameter.
    // You need to CREATE 'RemoveTrackFromPlaylistRequest'
    public function removeTrack(AddTrackToPlaylistRequest $request, Playlist $playlist, Track $track): JsonResponse
    {
        // FIXME: Temporarily using AddTrackToPlaylistRequest.
        // You MUST create and use RemoveTrackFromPlaylistRequest for proper authorization.
        $playlist->tracks()->detach($track->id);

        return response()->json([
            'message' => 'Track removed from playlist successfully.',
            'data' => $playlist->fresh('tracks')
        ]);
    }
}