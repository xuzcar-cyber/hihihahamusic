<?php
namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TrackController extends Controller
{
    public function index(Request $request)
{
    $genre = $request->genre;

    $newTracks = Track::with('user')
        ->when($genre, fn ($q) => $q->where('genre', $genre))
        ->latest()
        ->paginate(6, ['*'], 'new_page');

    $popularTracks = Track::with('user')
        ->when($genre, fn ($q) => $q->where('genre', $genre))
        ->orderByDesc('play_count')
        ->orderByDesc('likes_count')
        ->paginate(6, ['*'], 'popular_page');

    $newArtists = Track::with('user')
        ->when($genre, fn ($q) => $q->where('genre', $genre))
        ->select('user_id')
        ->distinct()
        ->latest()
        ->paginate(6, ['*'], 'artist_page');

    $genres = Track::whereNotNull('genre')
        ->distinct()
        ->pluck('genre');

    return view('tracks.index', compact(
        'newTracks',
        'popularTracks',
        'newArtists',
        'genres'
    ));
}
    public function show(Track $track)
    {
        $track->load('user', 'comments.user', 'comments.replies.user');

        return view('tracks.show', compact('track'));
    }

    public function create()
    {
        return view('tracks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'audio' => 'required|file|mimes:mp3,wav|max:20480',
            'cover' => 'nullable|image|max:10240',
        ]);

        $audioPath = $request->file('audio')->store('tracks', 'public');
        $coverPath = $request->hasFile('cover') ? $request->file('cover')->store('covers', 'public') : null;

        Track::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'artist' => $request->artist,
            'genre' => $request->genre,
            'file_path' => $audioPath,
            'cover_path' => $coverPath,
        ]);

        return redirect()->route('cabinet.index')->with('success', 'Трек загружен');
    }

    public function edit(Track $track)
    {
        abort_if($track->user_id !== Auth::id(), 403);

        return view('tracks.edit', compact('track'));
    }

    public function update(Request $request, Track $track)
    {
        abort_if($track->user_id !== Auth::id(), 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'audio' => 'nullable|file|mimes:mp3,wav|max:20480',
            'cover' => 'nullable|image|max:10240',
        ]);

        $track->title = $request->title;
        $track->artist = $request->artist;
        $track->genre = $request->genre;

        if ($request->hasFile('audio')) {
            Storage::disk('public')->delete($track->file_path);
            $track->file_path = $request->file('audio')->store('tracks', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($track->cover_path) {
                Storage::disk('public')->delete($track->cover_path);
            }
            $track->cover_path = $request->file('cover')->store('covers', 'public');
        }

        $track->save();

        return redirect()->route('cabinet.index')->with('success', 'Трек обновлён');
    }

    public function destroy(Track $track)
    {
        abort_if($track->user_id !== Auth::id(), 403);

        Storage::disk('public')->delete($track->file_path);

        if ($track->cover_path) {
            Storage::disk('public')->delete($track->cover_path);
        }

        $track->delete();

        return redirect()->route('cabinet.index')->with('success', 'Трек удалён');
    }

    public function top(Request $request)
{
    $query = User::query()
        ->withCount('tracks')
        ->withSum('tracks', 'play_count')
        ->withSum('tracks', 'likes_count');

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('genre')) {
        $query->whereHas('tracks', function ($q) use ($request) {
            $q->where('genre', $request->genre);
        });
    }

    $sort = $request->sort ?? 'likes';

    switch ($sort) {
        case 'plays':
            $query->orderByDesc('tracks_sum_play_count');
            break;

        case 'tracks':
            $query->orderByDesc('tracks_count');
            break;

        default:
            $query->orderByDesc('tracks_sum_likes_count');
    }

    $artists = $query->paginate(20);

    $genres = Track::distinct()
        ->whereNotNull('genre')
        ->pluck('genre');

    return view('top.index', compact(
        'artists',
        'genres'
    ));
}
}
