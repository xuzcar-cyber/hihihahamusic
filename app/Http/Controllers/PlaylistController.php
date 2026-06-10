<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Track;

class PlaylistController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $playlists = $user->playlists()->latest()->paginate(12);

        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover' => 'nullable|image|max:10240',
        ]);

        $coverPath = $request->hasFile('cover') ? $request->file('cover')->store('playlists', 'public') : null;

        Playlist::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'cover_path' => $coverPath,
        ]);

        return redirect()->route('cabinet.playlists.index')->with('success', 'Плейлист создан');
    }

    public function show(Playlist $playlist)
    {
        $this->authorize('view', $playlist);

        $tracks = $playlist->tracks()->paginate(12);

        return view('playlists.show', compact('playlist', 'tracks'));
    }

    public function edit(Playlist $playlist)
    {
        $this->authorize('update', $playlist);

        return view('playlists.edit', compact('playlist'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $this->authorize('update', $playlist);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover' => 'nullable|image|max:10240',
        ]);

        $playlist->name = $request->name;
        $playlist->description = $request->description;

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('playlists', 'public');
            $playlist->cover_path = $coverPath;
        }

        $playlist->save();

        return redirect()->route('cabinet.playlists.show', $playlist)->with('success', 'Плейлист обновлён');
    }

    public function destroy(Playlist $playlist)
    {
        $this->authorize('delete', $playlist);

        $playlist->delete();

        return redirect()->route('cabinet.playlists.index')->with('success', 'Плейлист удалён');
    }

   public function addTrack(Playlist $playlist, Track $track)
{
    if (!$playlist->tracks()->where('track_id', $track->id)->exists()) {

        $position = ($playlist->tracks()->max('position') ?? 0) + 1;

        $playlist->tracks()->attach($track->id, [
            'position' => $position
        ]);
    }

    return back()->with('success', 'Трек добавлен в плейлист');
}

    public function removeTrack(Request $request, Playlist $playlist)
    {
        $this->authorize('update', $playlist);

        $request->validate(['track_id' => 'required|exists:tracks,id']);

        if ($playlist->tracks()->where('track_id', $request->track_id)->exists()) {
            $playlist->tracks()->detach($request->track_id);
            $playlist->decrement('tracks_count');
        }

        return back()->with('success', 'Трек удален из плейлиста');
    }
}
