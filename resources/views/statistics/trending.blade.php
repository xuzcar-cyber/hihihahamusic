@extends('layouts.app')

@section('content')
<h1>🔥 Популярные треки</h1>
<div class="row">
    @foreach($tracks as $track)
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="{{ $track->cover_url ?? 'https://via.placeholder.com/300' }}" class="card-img-top" style="height:200px; object-fit:cover">
                <div class="card-body">
                    <h5><a href="{{ route('tracks.show', $track) }}">{{ $track->title }}</a></h5>
                    <p class="text-muted">
                        <a href="{{ route('profile', $track->user) }}">{{ $track->artist }}</a>
                    </p>
                    <p class="small">
                        ❤️ {{ $track->likes_count }} | 👁️ {{ $track->view_count }} | ▶️ {{ $track->play_count }}
                    </p>
                    <button onclick='playTrack(@json($track->id), @json($track->audio_url), @json($track->title), @json($track->artist), @json($track->cover_url ?? "https://via.placeholder.com/300"))' class="btn btn-success btn-sm w-100 mb-2">▶ Слушать</button>
                    <a href="{{ route('tracks.show', $track) }}" class="btn btn-primary btn-sm w-100">Подробнее</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
{{ $tracks->links() }}
@endsection
