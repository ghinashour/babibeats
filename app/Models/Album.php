<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
     protected $fillable = ['artist_id','title','released_at','cover_image'];

  public function artist(){
     return $this->belongsTo(Artist::class); 
    }

  public function tracks(){
     return $this->hasMany(Track::class);
     }
     
    public function favorites()
{
    return $this->morphMany(Favorite::class, 'favoritable');
}

}
