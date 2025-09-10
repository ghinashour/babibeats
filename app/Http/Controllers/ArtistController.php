<?php

namespace App\Http\Controllers;
use App\Models\Artist;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function index(){
        return Artist::all();
    }
    public function show($id){
        return Artist::with('albums.tracks')->findOrFail($id);
    }

    public function store(StoreArtistRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('artist-profiles', 'public');
            $validated['profile_image'] = $imagePath;
        }

        $artist = Artist::create($validated);

        return response()->json([
            'message' => 'Artist created successfully.',
            'data' => $artist
        ], 201);
    }

    /**
     * Update the specified artist.
     */
    public function update(UpdateArtistRequest $request, Artist $artist): JsonResponse
    {
        $validated = $request->validated();

        // Handle new profile image upload if provided
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($artist->profile_image && Storage::disk('public')->exists($artist->profile_image)) {
                Storage::disk('public')->delete($artist->profile_image);
            }
            
            $imagePath = $request->file('profile_image')->store('artist-profiles', 'public');
            $validated['profile_image'] = $imagePath;
        }

        $artist->update($validated);

        return response()->json([
            'message' => 'Artist updated successfully.',
            'data' => $artist->fresh()
        ]);
    }

    /**
     * Remove the specified artist.
     */
    public function destroy(Artist $artist): JsonResponse
    {
        // Delete associated profile image
        if ($artist->profile_image && Storage::disk('public')->exists($artist->profile_image)) {
            Storage::disk('public')->delete($artist->profile_image);
        }

        $artist->delete();

        return response()->json([
            'message' => 'Artist deleted successfully.'
        ], 200);
    }
}

