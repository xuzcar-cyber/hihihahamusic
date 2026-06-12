@extends('layouts.app')
@section('title', 'Избранное - ХиХиХа Музыка')
@section('content')
<section class="hero-panel">
    <div class="hero-kicker">Коллекция</div>
    <h1>Избранное</h1>
    <p class="lead mb-0">Треки, к которым хочется возвращаться.</p>
</section>

<section class="section-panel">
    @if($favorites->count())
        <div class="row g-4">
            @foreach($favorites as $favorite)
                @if($favorite->track)
                    <div class="col-sm-6 col-lg-4">
                        <div class="card track-card h-100">
                            <img src="{{ $favorite->track->cover_url ?? 'https://via.placeholder.com/600x600?text=Favorite' }}" class="card-img-top" alt="Обложка {{ $favorite->track->title }}">
                            <div class="card-body">
                                <h5>{{ $favorite->track->title }}</h5>
                                <p class="text-muted">{{ $favorite->track->artist }}</p>
                                <div class="d-flex flex-wrap gap-2 mt-auto">
                                    <button onclick='playTrack(@json($favorite->track->id), @json($favorite->track->audio_url), @json($favorite->track->title), @json($favorite->track->artist), @json($favorite->track->cover_url ?? "https://via.placeholder.com/300"))' class="btn btn-success btn-sm">Слушать</button>
                                    <a href="{{ route('tracks.show', $favorite->track) }}" class="btn btn-primary btn-sm">Подробнее</a>
                                    <form action="{{ route('tracks.favorite', $favorite->track) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Убрать</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="mt-4">{{ $favorites->links() }}</div>
    @else
        <p class="text-muted mb-0">Избранное пока пустое. <a href="{{ route('tracks.index') }}">Найдите треки</a>, которые хочется сохранить.</p>
    @endif
</section>
@endsection
