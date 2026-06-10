@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h2>{{ $track->title }}</h2>
                <p class="text-muted">
                    <strong>Исполнитель:</strong> <a href="{{ route('profile', $track->user) }}">{{ $track->artist }}</a>
                    | <strong>Жанр:</strong> {{ $track->genre ?? 'N/A' }}
                </p>

                <!-- Аудиоплеер -->
                <div class="mb-3">
                    <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/300"))' class="btn btn-lg btn-success">
                        ▶ Слушать трек
                    </button>
                </div>

                <div class="mb-3">
                    <!-- Форма лайка -->
                    <form action="{{ route('tracks.like', $track) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            ❤️ {{ $track->likes_count }} лайков
                        </button>
                    </form>

                    <!-- Избранное -->
                    @auth
                        <form action="{{ route('tracks.favorite', $track) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn {{ auth()->user()->isFavorited($track) ? 'btn-warning' : 'btn-outline-warning' }}">
                                ⭐ {{ auth()->user()->isFavorited($track) ? 'В избранном' : 'Добавить в избранное' }}
                            </button>
                        </form>
                    @endauth

                    <!-- Добавить в плейлист -->
                    @auth
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addToPlaylistModal">
                            📋 Добавить в плейлист
                        </button>
                    @endauth

                    @auth
                        @if(auth()->id() !== $track->user_id)
                            @php
                                $isSubscribed = auth()->user()->followings()
                                                ->where('followed_id', $track->user_id)
                                                ->exists();
                            @endphp
                            <form action="{{ route('subscribe.toggle', $track->user) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    {{ $isSubscribed ? '✓ Подписан' : '+ Подписаться' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                <div class="text-muted small mb-3">
                    👁️ Просмотров: {{ $track->view_count }} | ▶️ Прослушиваний: {{ $track->play_count }}
                </div>

                <hr>

                <!-- Блок комментариев -->
                <h5>Комментарии ({{ $track->comments->count() }})</h5>

                @auth
                    <form method="POST" action="{{ route('comments.store', $track) }}" class="mb-4">
                        @csrf
                        <textarea name="body" class="form-control mb-2" rows="2" placeholder="Ваш комментарий..." required></textarea>
                        <button type="submit" class="btn btn-sm btn-primary">Отправить</button>
                    </form>
                @else
                    <p class="text-muted"><a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.</p>
                @endauth

                @forelse($track->comments->where('parent_id', null) as $comment)
                    <div class="border p-2 my-2">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $comment->user->name ?? 'Удалён' }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $comment->body }}</p>

                        @auth
                            <button class="btn btn-sm btn-link p-0" onclick="document.getElementById('reply-{{ $comment->id }}').style.display='block'">
                                Ответить
                            </button>
                        @endauth

                        <div id="reply-{{ $comment->id }}" style="display:none;" class="mt-2">
                            <form method="POST" action="{{ route('comments.store', $track) }}">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="body" class="form-control form-control-sm" rows="2" placeholder="Ваш ответ..."></textarea>
                                <button type="submit" class="btn btn-sm btn-secondary mt-1">Ответить</button>
                            </form>
                        </div>

                        <!-- Вложенные ответы -->
                        @foreach($comment->replies as $reply)
                            <div class="ms-4 border-start ps-3 mt-2">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $reply->user->name ?? 'Удалён' }}</strong>
                                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $reply->body }}</p>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-muted">Пока нет комментариев. Будьте первым!</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Исполнитель</div>
            <div class="card-body text-center">
                <img src="{{ $track->user->avatar ?? 'https://via.placeholder.com/150' }}" class="rounded-circle mb-3" width="120">
                <h5>{{ $track->user->name }}</h5>
                <p class="text-muted">{{ $track->user->bio ?? 'Нет описания' }}</p>
                <a href="{{ route('profile', $track->user) }}" class="btn btn-primary btn-sm">Профиль</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal для добавления в плейлист -->
@auth
<div class="modal fade" id="addToPlaylistModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить в плейлист</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(auth()->user()->playlists->count())
                    <div class="list-group">
                        @foreach(auth()->user()->playlists as $playlist)
                            <form action="{{ route('cabinet.playlists.add-track', $playlist) }}" method="POST" class="list-group-item list-group-item-action">
                                @csrf
                                <input type="hidden" name="track_id" value="{{ $track->id }}">
                                <button type="submit" class="w-100 text-start">
                                    {{ $playlist->name }} ({{ $playlist->tracks()->count() }} треков)
                                </button>
                            </form>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">У вас нет плейлистов. <a href="{{ route('cabinet.playlists.create') }}">Создать</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endauth

<script>
    // Record view
    fetch("{{ route('tracks.record-view', $track) }}", { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    // Record play when audio ends
    document.querySelector('audio')?.addEventListener('ended', function() {
        fetch("{{ route('tracks.record-play', $track) }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ seconds_played: Math.round(this.duration) })
        });
    });
</script>
@endsection