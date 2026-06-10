@extends('layouts.app')

@section('content')
<h1>⭐ Топ артистов</h1>
<form method="GET" class="row mb-4">

    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Поиск исполнителя"
            value="{{ request('search') }}"
        >
    </div>

    <div class="col-md-3">
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
        <select name="sort" class="form-select">

            <option value="likes"
                @selected(request('sort')=='likes')
            >
                По лайкам
            </option>

            <option value="plays"
                @selected(request('sort')=='plays')
            >
                По прослушиваниям
            </option>

            <option value="tracks"
                @selected(request('sort')=='tracks')
            >
                По трекам
            </option>

        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            Найти
        </button>
    </div>

</form>
<div class="table-responsive">
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Артист</th>
                <th>Треков</th>
                <th>Лайков</th>
                <th>Прослушиваний</th>
            </tr>
        </thead>
        <tbody>
            @foreach($artists as $artist)
                <tr>
                    <td>
                        <strong>{{ $artist->artist }}</strong>
                    </td>
                    <td>{{ $artist->track_count }}</td>
                    <td>❤️ {{ $artist->total_likes ?? 0 }}</td>
                    <td>▶️ {{ $artist->total_plays ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $artists->links() }}
@endsection
