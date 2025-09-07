<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
     protected $fillable = ['name','bio','profile_image'];

  public function albums(){ return $this->hasMany(Album::class); }
  public function tracks(){ return $this->hasMany(Track::class); }
  public function favorites(){return $this -> morphmany(Favorite::class, 'favorable')}
}
