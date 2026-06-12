@extends('layouts.app')
@section('title', 'Плейлисты - ХиХиХа Музыка')
@section('content')
<section class="hero-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div><div class="hero-kicker">Подборки</div><h1>Мои плейлисты</h1><p class="lead mb-0">Собирайте треки под настроение, вечер или дорогу.</p></div>
        <a href="{{ route('cabinet.playlists.create') }}" class="btn btn-success">Создать плейлист</a>
    </div>
</section>
<section class="section-panel">
    @if($playlists->count())
        <div class="row g-4">
            @foreach($playlists as $playlist)
                <div class="col-sm-6 col-lg-4">
                    <div class="card h-100">
                        <img src="{{ $playlist->cover_url ?? 'https://via.placeholder.com/600x600?text=Playlist' }}" class="card-img-top" alt="Обложка {{ $playlist->name }}">
                        <div class="card-body">
                            <h5>{{ $playlist->name }}</h5>
                            <p class="text-muted">{{ $playlist->description ?? 'Без описания' }}</p>
                            <p><strong>{{ $playlist->tracks_count }}</strong> треков</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('cabinet.playlists.show', $playlist) }}" class="btn btn-sm btn-primary">Открыть</a>
                                <a href="{{ route('cabinet.playlists.edit', $playlist) }}" class="btn btn-sm btn-warning">Изменить</a>
                                <form action="{{ route('cabinet.playlists.destroy', $playlist) }}" method="POST" onsubmit="return confirm('Удалить плейлист?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $playlists->links() }}</div>
    @else
        <p class="text-muted mb-0">У вас пока нет плейлистов. <a href="{{ route('cabinet.playlists.create') }}">Создайте первый</a>.</p>
    @endif
</section>
@endsection
