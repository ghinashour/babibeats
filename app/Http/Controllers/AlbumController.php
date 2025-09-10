<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index(){
        return Album::with('artist')->get();
    }
    public function show($id){
        returnAlbum::with(['artist', 'tracks'])->findOrFail($id);
    }


    public function store(StoreAlbumRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('album-covers', 'public');
            $validated['cover_image'] = $imagePath;
        }

        $album = Album::create($validated);

        return response()->json([
            'message' => 'Album created successfully.',
            'data' => $album->load('artist')
        ], 201);
    }

    /**
     * Update the specified album.
     */
    public function update(UpdateAlbumRequest $request, Album $album): JsonResponse
    {
        $validated = $request->validated();

        // Handle new cover image upload if provided
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
                Storage::disk('public')->delete($album->cover_image);
            }
            
            $imagePath = $request->file('cover_image')->store('album-covers', 'public');
            $validated['cover_image'] = $imagePath;
        }

        $album->update($validated);

        return response()->json([
            'message' => 'Album updated successfully.',
            'data' => $album->fresh('artist')
        ]);
    }

    /**
     * Remove the specified album.
     */
    public function destroy(Album $album): JsonResponse
    {
        // Delete associated cover image
        if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->delete();

        return response()->json([
            'message' => 'Album deleted successfully.'
        ], 200);
    }
}
