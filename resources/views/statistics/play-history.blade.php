@extends('layouts.app')
@section('title', 'История прослушиваний - ХиХиХа Музыка')
@section('content')
<section class="hero-panel"><div class="hero-kicker">Ваш след</div><h1>История прослушиваний</h1><p class="lead mb-0">Все треки, которые вы запускали недавно.</p></section>
<section class="section-panel">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-6"><input name="search" class="form-control" value="{{ request('search') }}" placeholder="Поиск по треку или артисту"></div>
        <div class="col-md-4"><select name="genre" class="form-select"><option value="">Все жанры</option>@foreach($genres as $genre)<option value="{{ $genre }}" @selected(request('genre') == $genre)>{{ $genre }}</option>@endforeach</select></div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Показать</button></div>
    </form>
    @if($history->count())
        <div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>Трек</th><th>Артист</th><th>Жанр</th><th>Прослушано</th><th>Дата</th></tr></thead>
            <tbody>
                @foreach($history as $record)
                    <tr><td class="fw-bold">{{ $record->track->title }}</td><td>{{ $record->track->artist }}</td><td>{{ $record->track->genre ?? '-' }}</td><td>{{ $record->seconds_played }} сек.</td><td>{{ $record->created_at->format('d.m.Y H:i') }}</td></tr>
                @endforeach
            </tbody>
        </table></div>
        {{ $history->withQueryString()->links() }}
    @else
        <p class="text-muted mb-0">Вы еще не слушали треки. <a href="{{ route('tracks.index') }}">Откройте музыку</a>.</p>
    @endif
</section>
@endsection
