<?php

namespace App\Models;
//the user should have an api token so that when logging in he can stay there
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Favorite;
use App\Models\Playlist;
use App\Models\ListeningHistory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function listeningHistories()
    {
        return $this->hasMany(ListeningHistory::class);
    }
}