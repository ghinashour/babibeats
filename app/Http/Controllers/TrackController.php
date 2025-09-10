<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreTrackRequest;
use App\Http\Requests\UpdateTrackRequest;
use App\Models\Track;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index(){
        return Track::with(['artist', 'album'])->paginate(20);
    }
    public function show($id){
        return Track::with(['artist', 'album'])->findOrFail($id);
    }

     public function store(StoreTrackRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Handle file upload
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tracks', 'public');
            $validated['file_path'] = $filePath;
        }

        $track = Track::create($validated);

        return response()->json([
            'message' => 'Track uploaded successfully.',
            'data' => $track->load('artist', 'album')
        ], 201);
    }

    /**
     * Update the specified track.
     */
    public function update(UpdateTrackRequest $request, Track $track): JsonResponse
    {
        $validated = $request->validated();

        // Handle new file upload if provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($track->file_path && Storage::disk('public')->exists($track->file_path)) {
                Storage::disk('public')->delete($track->file_path);
            }
            
            $filePath = $request->file('file')->store('tracks', 'public');
            $validated['file_path'] = $filePath;
        }

        $track->update($validated);

        return response()->json([
            'message' => 'Track updated successfully.',
            'data' => $track->fresh(['artist', 'album'])
        ]);
    }

    /**
     * Remove the specified track.
     */
    public function destroy(Track $track): JsonResponse
    {
        // Delete associated file
        if ($track->file_path && Storage::disk('public')->exists($track->file_path)) {
            Storage::disk('public')->delete($track->file_path);
        }

        $track->delete();

        return response()->json([
            'message' => 'Track deleted successfully.'
        ], 200);
    }
}
