<?php
namespace App\Http\Controllers;
use App\Models\Playlist;
use App\Models\Track;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Http\Requests\AddTrackToPlaylistRequest;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class PlaylistController extends Controller
{
     public function index()
    {
        return Playlist::with('user')->get();
    }

    public function show($id)
    {
        return Playlist::with(['user', 'tracks'])->findOrFail($id);
    }

    public function addTrack(Request $request, $id)
{
    $playlist = Playlist::findOrFail($id);
    if ($playlist->tracks()->where('track_id', $request->track_id)->exists()) {
        return response()->json(['message' => 'Track already in playlist'], 409);
    }
    $playlist->tracks()->attach($request->track_id, [
        'position' => $playlist->tracks()->count() + 1,
    ]);
    return response()->json(['message' => 'Track added to playlist']);
}

    public function removeTrack($id, $trackId)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->tracks()->detach($trackId);
        return response()->json(['message' => 'Track removed from playlist']);
    }

    public function store(StorePlaylistRequest $request): JsonResponse
    {
        // The validated data is already available
        $validated = $request->validated();

        // Create the playlist and associate it with the current user
        $playlist = $request->user()->playlists()->create($validated);

        // Return a JSON response with the newly created playlist
        return response()->json([
            'message' => 'Playlist created successfully.',
            'data' => $playlist->load('tracks') // Load relationships if needed
        ], 201); // HTTP 201 Created
    }

    //updating a specified playlist  here
     public function update(UpdatePlaylistRequest $request, string $id): JsonResponse
    {
        // The UpdatePlaylistRequest has already authorized the user
        // and validated the data. We can just find the playlist and update it.
        $playlist = Playlist::findOrFail($id);

        $playlist->update($request->validated());

        return response()->json([
            'message' => 'Playlist updated successfully.',
            'data' => $playlist->fresh() // fresh() reloads the model from the database
        ]);
    } 


    //deleting a list the user want to be deleted
     public function destroy(string $id): JsonResponse
    {
        // Find the playlist
        $playlist = Playlist::findOrFail($id);

        // Authorize: Check if the user owns the playlist
        if ($playlist->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'You can only delete your own playlists.',
            ], 403);
        }

        // Delete the playlist
        $playlist->delete();

        return response()->json([
            'message' => 'Playlist deleted successfully.',
        ], 200); // or 204 No Content
    }

        public function addTrack(AddTrackToPlaylistRequest $request, $id)
    {
        // Request is authorized and validated
        $playlist = Playlist::find($id);
        $trackId = $request->input('track_id') || $request->route('trackId'); // Adjust based on your method signature

        $playlist->tracks()->attach($trackId);

        return response()->json(['message' => 'Track added to playlist.']);
    }

      public function removeTrack(AddTrackToPlaylistRequest $request, Playlist $playlist, Track $track): JsonResponse
    {
        $playlist->tracks()->detach($track->id);

        return response()->json([
            'message' => 'Track removed from playlist successfully.',
            'data' => $playlist->fresh('tracks')
        ]);
    }
}
