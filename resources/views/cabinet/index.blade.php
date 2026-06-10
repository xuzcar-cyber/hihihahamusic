@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Мой профиль</div>
            <div class="card-body text-center">
                <img src="{{ $user->avatar ?? 'https://via.placeholder.com/150' }}" class="rounded-circle mb-3" width="120">
                <h4>{{ $user->name }}</h4>
                <p>{{ $user->email }}</p>
                <p class="text-muted">{{ $user->bio ?? 'Нет описания' }}</p>
                <a href="{{ route('cabinet.profile.edit') }}" class="btn btn-sm btn-outline-primary">Редактировать профиль</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Статистика</div>
            <div class="card-body">
                <p><strong>Треки:</strong> {{ $user->tracks()->count() }}</p>
                <p><strong>Лайков:</strong> {{ $user->likes()->count() }}</p>
                <p><strong>Подписчиков:</strong> {{ $user->followers()->count() }}</p>
                <p><strong>Плейлистов:</strong> {{ $user->playlists()->count() }}</p>
                <p><strong>Избранного:</strong> {{ $user->favorites()->count() }}</p>
                <a href="{{ route('cabinet.playlists.index') }}" class="btn btn-sm btn-primary mt-2">Мои плейлисты</a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                Мои треки
                <a href="{{ route('cabinet.tracks.create') }}" class="btn btn-success btn-sm">+ Загрузить трек</a>
            </div>
            <div class="card-body">
                @if($tracks->count())
                    <div class="list-group">
                        @foreach($tracks as $track)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $track->title }}</strong><br>
                                        <small>{{ $track->artist }} | ❤️ {{ $track->likes_count }} | 👁️ {{ $track->view_count }} | ▶️ {{ $track->play_count }}</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-success play-btn" 
                                            data-track-id="{{ $track->id }}"
                                            data-audio-url="{{ $track->audio_url }}"
                                            data-title="{{ $track->title }}"
                                            data-artist="{{ $track->artist }}"
                                            data-cover="{{ $track->cover_url ?? 'https://via.placeholder.com/50' }}">▶</button>
                                        <a href="{{ route('tracks.show', $track) }}" class="btn btn-sm btn-info">Смотреть</a>
                                        <a href="{{ route('cabinet.tracks.edit', $track) }}" class="btn btn-sm btn-warning">Изменить</a>
                                        <form action="{{ route('cabinet.tracks.destroy', $track) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить трек?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $tracks->links() }}
                @else
                    <p class="text-muted">У вас пока нет треков. <a href="{{ route('cabinet.tracks.create') }}">Загрузите первый!</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection