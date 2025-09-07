<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{

     protected $fillable = ['user_id','name','description','is_public'];
        //one to one , each playlist belong to one user
        public function user()
        {
            return $this->belongsTo(User::class);
        }
        //many tracks can have many playlists using a pivot table
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
