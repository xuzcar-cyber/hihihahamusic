<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'cover_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_track')
                    ->withPivot('position')
                    ->orderBy('position');
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover_path ? asset('storage/' . $this->cover_path) : null;
    }
}
