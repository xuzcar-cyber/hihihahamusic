<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Track;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Playlist;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'tracksCount' => Track::count(),
            'commentsCount' => Comment::count(),
            'favoritesCount' => Favorite::count(),
            'playlistsCount' => Playlist::count(),
        ]);
    }

    public function users()
    {
        $users = User::latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function tracks()
    {
        $tracks = Track::with('user')->latest()->paginate(20);

        return view('admin.tracks.index', compact('tracks'));
    }

    public function destroyTrack(Track $track)
    {
        $track->delete();

        return back()->with('success', 'Трек удалён');
    }

    public function makeAdmin(User $user)
    {
        $user->update([
            'is_admin' => true,
        ]);

        return back()->with('success', 'Пользователь назначен администратором');
    }
}