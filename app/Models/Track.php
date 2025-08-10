<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
        protected $fillable = ['album_id','artist_id','title','duration_seconds','file_path'];

        public function album(){ return $this->belongsTo(Album::class); }
        public function artist(){ return $this->belongsTo(Artist::class); }
        public function playlists(){ return $this->belongsToMany(Playlist::class)->withTimestamps()->using('App\\Models\\PlaylistTrack'); }
        public function favorites(){ return $this->morphMany(Favorite::class, 'favoritable'); }
        
}
