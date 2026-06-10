@extends('layouts.app')

@section('content')

<h1 class="mb-4">Главная</h1>

<form method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <select name="genre" class="form-select">
                <option value="">Все жанры</option>

                @foreach($genres as $genre)
                    <option
                        value="{{ $genre }}"
                        @selected(request('genre') == $genre)
                    >
                        {{ $genre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary">
                Фильтровать
            </button>
        </div>
    </div>
</form>

{{-- НОВОЕ --}}
<div class="mb-5">
    <h2>🆕 Новое</h2>

    <div class="row">
        @foreach($newTracks as $track)
            <div class="col-md-4 mb-3">
                <div class="card h-100">

                    <img
                        src="{{ $track->cover_url ?? 'https://via.placeholder.com/300' }}"
                        class="card-img-top"
                        style="height:220px;object-fit:cover"
                    >

                    <div class="card-body">
                        <h5>{{ $track->title }}</h5>
                        <p>{{ $track->artist }}</p>

                        <a
                            href="{{ route('tracks.show', $track) }}"
                            class="btn btn-primary btn-sm"
                        >
                            Подробнее
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    {{ $newTracks->withQueryString()->links() }}
</div>

<hr>

{{-- ПОПУЛЯРНОЕ --}}
<div class="mb-5">
    <h2>🔥 Популярное</h2>

    <div class="row">
        @foreach($popularTracks as $track)
            <div class="col-md-4 mb-3">
                <div class="card h-100">

                    <img
                        src="{{ $track->cover_url ?? 'https://via.placeholder.com/300' }}"
                        class="card-img-top"
                        style="height:220px;object-fit:cover"
                    >

                    <div class="card-body">
                        <h5>{{ $track->title }}</h5>

                        <p>
                            ❤️ {{ $track->likes_count }}
                            |
                            ▶️ {{ $track->play_count }}
                        </p>

                        <a
                            href="{{ route('tracks.show', $track) }}"
                            class="btn btn-success btn-sm"
                        >
                            Подробнее
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    {{ $popularTracks->withQueryString()->links() }}
</div>

<hr>

{{-- НОВЫЕ ИСПОЛНИТЕЛИ --}}
<div class="mb-5">
    <h2>🎤 Новые исполнители</h2>

    <div class="row">
        @foreach($newArtists as $artist)
            <div class="col-md-4 mb-3">

                <div class="card">
                    <div class="card-body">

                        <h5>
                            {{ $artist->user->name ?? $artist->artist }}
                        </h5>

                        <a
                            href="{{ route('profile', $artist->user) }}"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Профиль
                        </a>

                    </div>
                </div>

            </div>
        @endforeach
    </div>

    {{ $newArtists->withQueryString()->links() }}
</div>

@endsection