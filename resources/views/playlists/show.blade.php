@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <h2>{{ $playlist->name }}</h2>
                <p class="text-muted">{{ $playlist->description }}</p>
                <p>📋 <strong>{{ $playlist->tracks_count }}</strong> треков</p>
                @auth
                    @can('update', $playlist)
                        <a href="{{ route('cabinet.playlists.edit', $playlist) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('cabinet.playlists.destroy', $playlist) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить плейлист?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                    @endcan
                @endauth
            </div>
        </div>

        <div class="card">
            <div class="card-header">Треки</div>
            <div class="card-body">
                @if($tracks->count())
                    <div class="list-group">
                        @foreach($tracks as $track)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5><a href="{{ route('tracks.show', $track) }}">{{ $track->title }}</a></h5>
                                        <p class="text-muted">{{ $track->artist }} | ❤️ {{ $track->likes_count }}</p>
                                    </div>
                                    <div>
                                    <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/50"))' class="btn btn-sm btn-success">▶ Слушать</button>
                                        <a href="{{ route('tracks.show', $track) }}" class="btn btn-sm btn-primary">Подробнее</a>
                                        @auth
                                            @can('update', $playlist)
                                                <form action="{{ route('cabinet.playlists.remove-track', $playlist) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить из плейлиста?')">
                                                    @csrf
                                                    <input type="hidden" name="track_id" value="{{ $track->id }}">
                                                    <button class="btn btn-sm btn-danger">Удалить</button>
                                                </form>
                                            @endcan
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $tracks->links() }}
                @else
                    <p class="text-muted">В плейлисте нет треков.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($playlist->cover_path)
            <div class="card">
                <img src="{{ Storage::disk('public')->url($playlist->cover_path) }}" class="card-img-top">
            </div>
        @endif
    </div>
</div>
@endsection
