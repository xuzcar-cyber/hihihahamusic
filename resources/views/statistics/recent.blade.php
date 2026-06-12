@extends('layouts.app')
@section('title', 'Новое - ХиХиХа Музыка')
@section('content')
<section class="hero-panel"><div class="hero-kicker">Свежие релизы</div><h1>Новые треки</h1><p class="lead mb-0">Последние загрузки на платформе.</p></section>
<section class="section-panel">
    <div class="row g-4">
        @foreach($tracks as $track)
            <div class="col-sm-6 col-lg-4"><div class="card track-card h-100">
                <img src="{{ $track->cover_url ?? 'https://via.placeholder.com/600x600?text=New' }}" class="card-img-top" alt="Обложка {{ $track->title }}">
                <div class="card-body"><h5>{{ $track->title }}</h5><p class="text-muted">{{ $track->artist }}</p>
                    <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/300"))' class="btn btn-success btn-sm mb-2">Слушать</button>
                    <a href="{{ route('tracks.show', $track) }}" class="btn btn-primary btn-sm mb-2">Подробнее</a>
                </div>
            </div></div>
        @endforeach
    </div>
    <div class="mt-4">{{ $tracks->links() }}</div>
</section>
@endsection
