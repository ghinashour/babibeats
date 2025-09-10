<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\PlaylistController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;



// Configure rate limiting
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

RateLimiter::for('uploads', function (Request $request) {
    return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
});



// Public routes (login, browse artists, albums, tracks)
Route::post('/login', function (Request $request) {
    
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
})->middleware('throttle:login');

// Public routes with rate limiting
Route::middleware('throttle:60,1')->group(function () {
Route::get('/artists', [ArtistController::class, 'index']);
Route::get('/artists/{id}', [ArtistController::class, 'show']);
Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/{id}', [AlbumController::class, 'show']);
Route::get('/tracks', [TrackController::class, 'index']);
Route::get('/tracks/{id}', [TrackController::class, 'show']);

});




// Protected Routes (Require Authentication)
Route::middleware(['auth:sanctum','throttle:api'])->group(function () {

    // Users (Read-only in this case)
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    // Playlists (Full CRUD + track management)
    Route::apiResource('playlists', PlaylistController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);
    // Alternative to the above line: define each route manually as shown below.
    Route::post('/playlists/{id}/tracks', [PlaylistController::class, 'addTrack']);
    Route::delete('/playlists/{playlistId}/tracks/{trackId}', [PlaylistController::class, 'removeTrack']);

    // Tracks (Create/Upload)
    Route::post('/tracks', [TrackController::class, 'store']);
      Route::put('tracks/{track}', [TrackController::class, 'update']);
    Route::delete('tracks/{track}', [TrackController::class, 'destroy']);

      // Album creation
    Route::post('albums', [AlbumController::class, 'store']);
    Route::put('albums/{album}', [AlbumController::class, 'update']);
    Route::delete('albums/{album}', [AlbumController::class, 'destroy']);

     // Artist creation  
    Route::post('artists', [ArtistController::class, 'store']);
    Route::put('artists/{artist}', [ArtistController::class, 'update']);
    Route::delete('artists/{artist}', [ArtistController::class, 'destroy']);


    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    });

});










