@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $user->avatar ?? 'https://via.placeholder.com/150' }}" class="rounded-circle mb-3" width="150">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <p>{{ $user->bio ?? 'Пользователь не заполнил информацию о себе' }}</p>
                @auth
                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('subscribe.toggle', $user) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary">
                                {{ auth()->user()->followings()->where('followed_id', $user->id)->exists() ? 'Отписаться' : 'Подписаться' }}
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Треки пользователя {{ $user->name }}</div>
            <div class="card-body">
                @foreach($tracks as $track)
                    <div class="mb-3">
                        <h5>{{ $track->title }}</h5>
                        <p>{{ $track->artist }} | ❤️ {{ $track->likes_count }}</p>
                        <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/50"))' class="btn btn-success btn-sm">▶ Слушать</button>
                        <a href="{{ route('tracks.show', $track) }}" class="btn btn-primary btn-sm">Подробнее</a>
                        <hr>
                    </div>
                @endforeach
                {{ $tracks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection