<?php

namespace App\Http\Controllers;

use App\Models\PlayHistory;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function trending()
    {
        $tracks = Track::with('user')
            ->orderBy('likes_count', 'desc')
            ->orderBy('play_count', 'desc')
            ->limit(50)
            ->paginate(12);

        return view('statistics.trending', compact('tracks'));
    }

    public function recent()
    {
        $tracks = Track::with('user')
            ->latest()
            ->limit(50)
            ->paginate(12);

        return view('statistics.recent', compact('tracks'));
    }

    public function topArtists(Request $request)
{
    $query = Track::select('artist')
        ->addSelect(DB::raw('
            COUNT(*) as track_count,
            SUM(likes_count) as total_likes,
            SUM(play_count) as total_plays
        '))
        ->groupBy('artist');

    // Поиск
    if ($request->filled('search')) {
        $query->having('artist', 'like', '%' . $request->search . '%');
    }

    // Фильтр по жанру
    if ($request->filled('genre')) {
        $query->where('genre', $request->genre);
    }

    // Сортировка
    switch ($request->sort) {

        case 'plays':
            $query->orderByDesc('total_plays');
            break;

        case 'tracks':
            $query->orderByDesc('track_count');
            break;

        default:
            $query->orderByDesc('total_likes');
    }

    $artists = $query->paginate(20);

    $genres = Track::whereNotNull('genre')
        ->distinct()
        ->pluck('genre');

    return view(
        'statistics.top-artists',
        compact('artists', 'genres')
    );
}
    public function playHistory(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $history = $user->playHistory()
        ->with('track.user');

    // Поиск по названию или артисту
    if ($request->filled('search')) {
        $search = $request->search;

        $history->whereHas('track', function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('artist', 'like', "%{$search}%");
        });
    }

    // Фильтр по жанру
    if ($request->filled('genre')) {
        $history->whereHas('track', function ($query) use ($request) {
            $query->where('genre', $request->genre);
        });
    }

    $history = $history
        ->latest()
        ->paginate(20)
        ->withQueryString();

    $genres = Track::whereNotNull('genre')
        ->distinct()
        ->orderBy('genre')
        ->pluck('genre');

    return view('statistics.play-history', compact(
        'history',
        'genres'
    ));
}

    public function recordPlay(Request $request, Track $track)
    {
        $request->validate(['seconds_played' => 'nullable|integer|min:0']);

        $track->increment('play_count');

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->playHistory()->create([
            'track_id' => $track->id,
            'seconds_played' => $request->seconds_played ?? 0,
        ]);

        return response()->json(['success' => true]);
    }

    public function recordView(Track $track)
    {
        $track->increment('view_count');

        return response()->json(['success' => true]);
    }
}
