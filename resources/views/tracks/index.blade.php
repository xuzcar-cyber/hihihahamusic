@extends('layouts.app')

@section('title', 'Главная - ХиХиХа Музыка')

@section('content')
<section class="hero-panel">
    <div class="row align-items-end g-4">
        <div class="col-lg-8">
            <div class="hero-kicker">Музыкальная платформа</div>
            <h1>Слушайте новое, находите своих и собирайте настроение.</h1>
            <p class="lead mb-0">Треки, артисты и плейлисты в одном живом пространстве. Все страницы теперь говорят по-русски и выглядят как часть одного продукта.</p>
        </div>
        <div class="col-lg-4">
            <form method="GET" class="card border-0 shadow-none">
                <div class="card-body">
                    <label class="form-label fw-bold" for="genre">Жанр</label>
                    <div class="d-flex gap-2">
                        <select id="genre" name="genre" class="form-select">
                            <option value="">Все жанры</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}" @selected(request('genre') == $genre)>{{ $genre }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="submit">Показать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section-panel">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <div class="hero-kicker mb-1">Свежий релиз</div>
            <h2 class="mb-0">Новое</h2>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('recent') }}">Все новинки</a>
    </div>

    <div class="row g-4">
        @foreach($newTracks as $track)
            <div class="col-sm-6 col-lg-4">
                <div class="card track-card h-100">
                    <img src="{{ $track->cover_url ?? 'https://via.placeholder.com/600x600?text=Music' }}" class="card-img-top" alt="Обложка {{ $track->title }}">
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $track->title }}</h5>
                        <p class="text-muted mb-3">{{ $track->artist }}</p>
                        <a href="{{ route('tracks.show', $track) }}" class="btn btn-primary btn-sm">Открыть трек</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $newTracks->withQueryString()->links() }}</div>
</section>

<section class="section-panel">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <div class="hero-kicker mb-1">Выбор слушателей</div>
            <h2 class="mb-0">Популярное</h2>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('trending') }}">Смотреть топ</a>
    </div>

    <div class="row g-4">
        @foreach($popularTracks as $track)
            <div class="col-sm-6 col-lg-4">
                <div class="card track-card h-100">
                    <img src="{{ $track->cover_url ?? 'https://via.placeholder.com/600x600?text=Hit' }}" class="card-img-top" alt="Обложка {{ $track->title }}">
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $track->title }}</h5>
                        <p class="text-muted mb-3">Нравится: {{ $track->likes_count }} · Прослушиваний: {{ $track->play_count }}</p>
                        <a href="{{ route('tracks.show', $track) }}" class="btn btn-success btn-sm">Слушать</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $popularTracks->withQueryString()->links() }}</div>
</section>

<section class="section-panel">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <div class="hero-kicker mb-1">Новые голоса</div>
            <h2 class="mb-0">Новые исполнители</h2>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('top-artists') }}">Топ артистов</a>
    </div>

    <div class="row g-4">
        @foreach($newArtists as $artist)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="mb-2">{{ $artist->user->name ?? $artist->artist }}</h5>
                        <p class="text-muted">Загляните в профиль и откройте больше треков автора.</p>
                        <a href="{{ route('profile', $artist->user) }}" class="btn btn-outline-primary btn-sm">Профиль</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $newArtists->withQueryString()->links() }}</div>
</section>
@endsection
