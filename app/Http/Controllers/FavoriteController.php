<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $favorites = $user->favorites()
            ->with('track.user')
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Track $track)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $favorite = $user->favorites()->where('track_id', $track->id)->first();

        if ($favorite) {
            $favorite->delete();

            return back()->with('success', 'Трек удален из избранного');
        }

        $user->favorites()->create(['track_id' => $track->id]);

        return back()->with('success', 'Трек добавлен в избранное');
    }
}
