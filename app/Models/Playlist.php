<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{

     protected $fillable = ['user_id','name','description','is_public'];
        public function user()
        {
            return $this->belongsTo(User::class);
        }
       

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
