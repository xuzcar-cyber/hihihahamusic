@extends('layouts.app')

@section('content')
<div class="card">
    <form method="GET" class="row g-2 mb-3">

    <div class="col-md-5">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Поиск по треку или артисту"
            value="{{ request('search') }}"
        >
    </div>

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

    <div class="col-md-3">
        <button class="btn btn-primary w-100">
            Фильтровать
        </button>
    </div>

</form>
    <div class="card-header">📝 История прослушивания</div>
    <div class="card-body">
        @if($history->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Трек</th>
                            <th>Артист</th>
                            <th>Жанр</th>
                            <th>Время прослушивания</th>
                            <th>Когда</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $record)
                            <tr>
                                <td>
                                    <a href="{{ route('tracks.show', $record->track) }}">{{ $record->track->title }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('profile', $record->track->user) }}">{{ $record->track->artist }}</a>
                                </td>
                                <td>
                                    {{ $record->track->genre ?? '—' }}
                                </td>
                                <td>
                                    {{ sprintf('%02d:%02d', intdiv($record->seconds_played, 60), $record->seconds_played % 60) }}
                                </td>
                                <td>{{ $record->created_at->diffForHumans() }}</td>
                                <td>
                                    <button onclick='playTrack(@json($record->track->id), @json($record->track->audio_url), @json($record->track->title), @json($record->track->artist), @json($record->track->cover_url ?? "https://via.placeholder.com/50"))' class="btn btn-success btn-sm">▶</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $history->links() }}
        @else
            <p class="text-muted">Вы еще не слушали музыку. <a href="{{ route('tracks.index') }}">Найдите треки</a>!</p>
        @endif
    </div>
</div>
@endsection
