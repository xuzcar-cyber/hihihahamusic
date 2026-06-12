@extends('layouts.app')

@section('title', $track->title . ' - ХиХиХа Музыка')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <section class="hero-panel">
            <div class="row g-4 align-items-center">
                <div class="col-sm-5">
                    <img src="{{ $track->cover_url ?? 'https://via.placeholder.com/700x700?text=Music' }}" class="w-100 rounded-2 shadow" alt="Обложка {{ $track->title }}">
                </div>
                <div class="col-sm-7">
                    <div class="hero-kicker">Трек</div>
                    <h1 class="mb-3">{{ $track->title }}</h1>
                    <p class="lead mb-2">
                        <a href="{{ route('profile', $track->user) }}" class="fw-bold">{{ $track->artist }}</a>
                    </p>
                    <p class="text-muted mb-4">Жанр: {{ $track->genre ?? 'не указан' }}</p>

                    <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/300"))' class="btn btn-lg btn-success">
                        Слушать трек
                    </button>
                </div>
            </div>
        </section>

        <section class="section-panel">
            <div class="d-flex flex-wrap gap-2 mb-3">
                <form action="{{ route('tracks.like', $track) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Нравится: {{ $track->likes_count }}
                    </button>
                </form>

                @auth
                    <form action="{{ route('tracks.favorite', $track) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ auth()->user()->isFavorited($track) ? 'btn-warning' : 'btn-outline-warning' }}">
                            {{ auth()->user()->isFavorited($track) ? 'В избранном' : 'Добавить в избранное' }}
                        </button>
                    </form>

                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addToPlaylistModal">
                        Добавить в плейлист
                    </button>

                    @if(auth()->id() !== $track->user_id)
                        @php
                            $isSubscribed = auth()->user()->followings()
                                ->where('followed_id', $track->user_id)
                                ->exists();
                        @endphp
                        <form action="{{ route('subscribe.toggle', $track->user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary">
                                {{ $isSubscribed ? 'Вы подписаны' : 'Подписаться' }}
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            <div class="text-muted">
                Просмотров: {{ $track->view_count }} · Прослушиваний: {{ $track->play_count }}
            </div>
        </section>

        <section class="section-panel">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <div class="hero-kicker mb-1">Обсуждение</div>
                    <h2 class="mb-0">Комментарии ({{ $track->comments->count() }})</h2>
                </div>
            </div>

            @auth
                <form method="POST" action="{{ route('comments.store', $track) }}" class="mb-4">
                    @csrf
                    <textarea name="body" class="form-control mb-2" rows="3" placeholder="Ваш комментарий..." required></textarea>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            @else
                <p class="text-muted"><a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.</p>
            @endauth

            @forelse($track->comments->where('parent_id', null) as $comment)
                <div class="comment-box p-3 my-3">
                    <div class="d-flex justify-content-between gap-3">
                        <strong>{{ $comment->user->name ?? 'Удаленный пользователь' }}</strong>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-2">{{ $comment->body }}</p>

                    @auth
                        <button class="btn btn-sm btn-link p-0" onclick="document.getElementById('reply-{{ $comment->id }}').classList.remove('d-none')">
                            Ответить
                        </button>
                    @endauth

                    <div id="reply-{{ $comment->id }}" class="reply-form d-none mt-3">
                        <form method="POST" action="{{ route('comments.store', $track) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="body" class="form-control form-control-sm" rows="2" placeholder="Ваш ответ..."></textarea>
                            <button type="submit" class="btn btn-sm btn-secondary mt-2">Ответить</button>
                        </form>
                    </div>

                    @foreach($comment->replies as $reply)
                        <div class="ms-4 border-start ps-3 mt-3">
                            <div class="d-flex justify-content-between gap-3">
                                <strong>{{ $reply->user->name ?? 'Удаленный пользователь' }}</strong>
                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0">{{ $reply->body }}</p>
                        </div>
                    @endforeach
                </div>
            @empty
                <p class="text-muted mb-0">Пока нет комментариев. Будьте первым!</p>
            @endforelse
        </section>
    </div>

    <aside class="col-lg-4">
        <div class="card track-sidebar position-sticky">
            <div class="card-header">Исполнитель</div>
            <div class="card-body text-center">
                <img src="{{ $track->user->avatar_url ?? 'https://via.placeholder.com/240x240?text=Artist' }}" class="artist-avatar rounded-circle mb-3" width="126" height="126" alt="Аватар {{ $track->user->name }}">
                <h5>{{ $track->user->name }}</h5>
                <p class="text-muted">{{ $track->user->bio ?? 'Описание пока не добавлено' }}</p>
                <a href="{{ route('profile', $track->user) }}" class="btn btn-primary btn-sm">Открыть профиль</a>
            </div>
        </div>
    </aside>
</div>

@auth
<div class="modal fade" id="addToPlaylistModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить в плейлист</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                @if(auth()->user()->playlists->count())
                    <div class="list-group">
                        @foreach(auth()->user()->playlists as $playlist)
                            <form action="{{ route('cabinet.playlists.add-track', ['playlist' => $playlist->id, 'track' => $track->id]) }}" method="POST" class="list-group-item list-group-item-action">
                                @csrf
                                <input type="hidden" name="track_id" value="{{ $track->id }}">
                                <button type="submit" class="w-100 text-start border-0 bg-transparent">
                                    {{ $playlist->name }} ({{ $playlist->tracks()->count() }} треков)
                                </button>
                            </form>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">У вас пока нет плейлистов. <a href="{{ route('cabinet.playlists.create') }}">Создать плейлист</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endauth

<script>
    fetch("{{ route('tracks.record-view', $track) }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });

    document.querySelector('audio')?.addEventListener('ended', function() {
        fetch("{{ route('tracks.record-play', $track) }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ seconds_played: Math.round(this.duration) })
        });
    });
</script>
@endsection
