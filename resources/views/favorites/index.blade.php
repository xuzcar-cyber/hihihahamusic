@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Мое избранное</div>
    <div class="card-body">
        @if($favorites->count())
            <div class="row">
                @foreach($favorites as $favorite)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $favorite->track->cover_url ?? 'https://via.placeholder.com/300' }}" class="card-img-top" style="height:200px; object-fit:cover">
                            <div class="card-body">
                                <h5><a href="{{ route('tracks.show', $favorite->track) }}">{{ $favorite->track->title }}</a></h5>
                                <p>{{ $favorite->track->artist }} | ❤️ {{ $favorite->track->likes_count }}</p>
                                <div class="mt-2">
                                    <button onclick='playTrack(@json($favorite->track->id), @json($favorite->track->audio_url), @json($favorite->track->title), @json($favorite->track->artist), @json($favorite->track->cover_url ?? "https://via.placeholder.com/300"))' class="btn btn-success btn-sm play-btn-inline">▶ Слушать</button>
                                    <a href="{{ route('tracks.show', $favorite->track) }}" class="btn btn-primary btn-sm">Подробнее</a>
                                    <form action="{{ route('tracks.favorite', $favorite->track) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">⭐ Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $favorites->links() }}
        @else
            <p class="text-muted">Ваше избранное пусто. <a href="{{ route('tracks.index') }}">Найдите треки</a>, которые вам нравятся!</p>
        @endif
    </div>
</div>
@endsection
