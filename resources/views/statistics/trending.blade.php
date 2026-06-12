@extends('layouts.app')
@section('title', 'Популярное - ХиХиХа Музыка')
@section('content')
<section class="hero-panel"><div class="hero-kicker">В тренде</div><h1>Популярные треки</h1><p class="lead mb-0">Самые заметные треки по лайкам и прослушиваниям.</p></section>
<section class="section-panel">
    <div class="row g-4">
        @foreach($tracks as $track)
            <div class="col-sm-6 col-lg-4"><div class="card track-card h-100">
                <img src="{{ $track->cover_url ?? 'https://via.placeholder.com/600x600?text=Hit' }}" class="card-img-top" alt="Обложка {{ $track->title }}">
                <div class="card-body"><h5>{{ $track->title }}</h5><p class="text-muted">{{ $track->artist }}</p><p>Лайков: {{ $track->likes_count }} · Прослушиваний: {{ $track->play_count }}</p>
                    <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/300"))' class="btn btn-success btn-sm mb-2">Слушать</button>
                    <a href="{{ route('tracks.show', $track) }}" class="btn btn-primary btn-sm mb-2">Подробнее</a>
                </div>
            </div></div>
        @endforeach
    </div>
    <div class="mt-4">{{ $tracks->links() }}</div>
</section>
@endsection
