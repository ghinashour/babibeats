<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'is_public'];
    
    // One to one - each playlist belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Many tracks can have many playlists using a pivot
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_track')
                    ->withPivot('position')
                    ->withTimestamps();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}