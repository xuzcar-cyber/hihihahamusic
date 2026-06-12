@extends('layouts.app')
@section('title', $playlist->name . ' - ХиХиХа Музыка')
@section('content')
<section class="hero-panel">
    <div class="row g-4 align-items-center">
        <div class="col-sm-4 col-lg-3"><img src="{{ $playlist->cover_url ?? 'https://via.placeholder.com/600x600?text=Playlist' }}" class="w-100 rounded-2 shadow" alt="Обложка {{ $playlist->name }}"></div>
        <div class="col-sm-8 col-lg-9">
            <div class="hero-kicker">Плейлист</div>
            <h1>{{ $playlist->name }}</h1>
            <p class="lead">{{ $playlist->description ?? 'Без описания' }}</p>
            <p class="text-muted">{{ $playlist->tracks_count }} треков</p>
            <a href="{{ route('cabinet.playlists.edit', $playlist) }}" class="btn btn-warning">Редактировать</a>
            <form action="{{ route('cabinet.playlists.destroy', $playlist) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить плейлист?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>
    </div>
</section>
<section class="section-panel">
    <h2>Треки</h2>
    @if($tracks->count())
        <div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>Трек</th><th>Исполнитель</th><th>Жанр</th><th class="text-end">Действия</th></tr></thead>
            <tbody>
                @foreach($tracks as $track)
                    <tr>
                        <td class="fw-bold">{{ $track->title }}</td>
                        <td>{{ $track->artist }}</td>
                        <td>{{ $track->genre ?? 'не указан' }}</td>
                        <td class="text-end">
                            <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/50"))' class="btn btn-sm btn-success">Слушать</button>
                            <a href="{{ route('tracks.show', $track) }}" class="btn btn-sm btn-primary">Подробнее</a>
                            <form action="{{ route('cabinet.playlists.remove-track', $playlist) }}" method="POST" class="d-inline" onsubmit="return confirm('Убрать из плейлиста?')">
                                @csrf
                                <input type="hidden" name="track_id" value="{{ $track->id }}">
                                <button class="btn btn-sm btn-danger">Убрать</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table></div>
        {{ $tracks->links() }}
    @else
        <p class="text-muted mb-0">В плейлисте пока нет треков.</p>
    @endif
</section>
@endsection
