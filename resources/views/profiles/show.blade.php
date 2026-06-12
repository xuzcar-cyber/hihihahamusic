@extends('layouts.app')
@section('title', $user->name . ' - ХиХиХа Музыка')
@section('content')
<section class="hero-panel">
    <div class="row g-4 align-items-center">
        <div class="col-sm-3"><img src="{{ $user->avatar_url ?? 'https://via.placeholder.com/300x300?text=Artist' }}" class="profile-avatar rounded-circle w-100" alt="Аватар {{ $user->name }}"></div>
        <div class="col-sm-9">
            <div class="hero-kicker">Исполнитель</div>
            <h1>{{ $user->name }}</h1>
            <p class="lead">{{ $user->bio ?? 'Пользователь пока не рассказал о себе' }}</p>
            @auth
                @if(auth()->id() !== $user->id)
                    <form action="{{ route('subscribe.toggle', $user) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">{{ auth()->user()->followings()->where('followed_id', $user->id)->exists() ? 'Вы подписаны' : 'Подписаться' }}</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</section>
<section class="section-panel">
    <h2>Треки {{ $user->name }}</h2>
    @if($tracks->count())
        <div class="row g-4">
            @foreach($tracks as $track)
                <div class="col-sm-6 col-lg-4">
                    <div class="card track-card h-100">
                        <img src="{{ $track->cover_url ?? 'https://via.placeholder.com/600x600?text=Track' }}" class="card-img-top" alt="Обложка {{ $track->title }}">
                        <div class="card-body">
                            <h5>{{ $track->title }}</h5>
                            <p class="text-muted">{{ $track->genre ?? 'Жанр не указан' }}</p>
                            <div class="d-flex gap-2 mt-auto">
                                <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/50"))' class="btn btn-success btn-sm">Слушать</button>
                                <a href="{{ route('tracks.show', $track) }}" class="btn btn-primary btn-sm">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $tracks->links() }}</div>
    @else
        <p class="text-muted mb-0">У пользователя пока нет треков.</p>
    @endif
</section>
@endsection
