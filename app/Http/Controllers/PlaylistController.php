<?php

use App\Models\Playlist;
use App\Models\Track;
namespace App\Http\Controllers;

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
}
