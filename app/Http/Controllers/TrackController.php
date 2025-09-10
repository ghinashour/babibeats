<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrackRequest;
use App\Http\Requests\UpdateTrackRequest;
use App\Models\Track;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class TrackController extends Controller
{
    public function index(): JsonResponse
    {
        $tracks = Track::with(['artist', 'album'])->paginate(20);
        return response()->json($tracks);
    }

    public function show(Track $track): JsonResponse // FIXED: Route Model Binding
    {
        return response()->json($track->load(['artist', 'album']));
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