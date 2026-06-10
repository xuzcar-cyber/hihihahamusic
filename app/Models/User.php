<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Track;
use App\Models\Like;
use App\Models\Comment;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'followed_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'follower_id', 'followed_id');
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function playHistory()
    {
        return $this->hasMany(PlayHistory::class);
    }

    public function isFavorited(Track $track)
    {
        return $this->favorites()->where('track_id', $track->id)->exists();
    }

    public function isAdmin(): bool
{
    return (bool) $this->is_admin;

}
}

