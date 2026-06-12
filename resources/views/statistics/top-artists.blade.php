@extends('layouts.app')
@section('title', 'Топ артистов - ХиХиХа Музыка')
@section('content')
<section class="hero-panel"><div class="hero-kicker">Рейтинг</div><h1>Топ артистов</h1><p class="lead mb-0">Исполнители, которых слушают и сохраняют чаще всего.</p></section>
<section class="section-panel">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input name="search" class="form-control" value="{{ request('search') }}" placeholder="Поиск исполнителя"></div>
        <div class="col-md-3"><select name="genre" class="form-select"><option value="">Все жанры</option>@foreach($genres as $genre)<option value="{{ $genre }}" @selected(request('genre') == $genre)>{{ $genre }}</option>@endforeach</select></div>
        <div class="col-md-3"><select name="sort" class="form-select"><option value="likes" @selected(request('sort') == 'likes')>По лайкам</option><option value="plays" @selected(request('sort') == 'plays')>По прослушиваниям</option><option value="tracks" @selected(request('sort') == 'tracks')>По трекам</option></select></div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Найти</button></div>
    </form>
    <div class="table-responsive"><table class="table align-middle">
        <thead><tr><th>Исполнитель</th><th>Треки</th><th>Лайки</th><th>Прослушивания</th></tr></thead>
        <tbody>@foreach($artists as $artist)<tr><td class="fw-bold">{{ $artist->artist }}</td><td>{{ $artist->track_count }}</td><td>{{ $artist->total_likes }}</td><td>{{ $artist->total_plays }}</td></tr>@endforeach</tbody>
    </table></div>
    {{ $artists->withQueryString()->links() }}
</section>
@endsection
