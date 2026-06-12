@extends('layouts.app')
@section('title', 'Кабинет - ХиХиХа Музыка')
@section('content')
<section class="hero-panel">
    <div class="row g-4 align-items-center">
        <div class="col-md-8">
            <div class="hero-kicker">Личный кабинет</div>
            <h1>{{ $user->name }}</h1>
            <p class="lead mb-0">{{ $user->bio ?? 'Описание пока не добавлено' }}</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('cabinet.profile.edit') }}" class="btn btn-primary">Редактировать профиль</a>
            <a href="{{ route('cabinet.playlists.index') }}" class="btn btn-outline-primary mt-2 mt-md-0">Плейлисты</a>
        </div>
    </div>
</section>

<section class="section-panel">
    <div class="row g-3">
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $user->tracks()->count() }}</strong><p class="text-muted mb-0">Треков</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $user->likes()->count() }}</strong><p class="text-muted mb-0">Лайков</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $user->followers()->count() }}</strong><p class="text-muted mb-0">Подписчиков</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $user->playlists()->count() }}</strong><p class="text-muted mb-0">Плейлистов</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $user->favorites()->count() }}</strong><p class="text-muted mb-0">В избранном</p></div></div></div>
    </div>
</section>

<section class="section-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="mb-0">Мои треки</h2>
        <a href="{{ route('cabinet.tracks.create') }}" class="btn btn-success">Добавить трек</a>
    </div>

    @if($tracks->count())
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Название</th><th>Исполнитель</th><th>Жанр</th><th class="text-end">Действия</th></tr></thead>
                <tbody>
                    @foreach($tracks as $track)
                        <tr>
                            <td class="fw-bold">{{ $track->title }}</td>
                            <td>{{ $track->artist }}</td>
                            <td>{{ $track->genre ?? 'не указан' }}</td>
                            <td class="text-end">
                                <a href="{{ route('tracks.show', $track) }}" class="btn btn-sm btn-info">Открыть</a>
                                <a href="{{ route('cabinet.tracks.edit', $track) }}" class="btn btn-sm btn-warning">Изменить</a>
                                <form action="{{ route('cabinet.tracks.destroy', $track) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить трек?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $tracks->links() }}
    @else
        <p class="text-muted mb-0">У вас пока нет треков. <a href="{{ route('cabinet.tracks.create') }}">Загрузите первый</a>.</p>
    @endif
</section>
@endsection
