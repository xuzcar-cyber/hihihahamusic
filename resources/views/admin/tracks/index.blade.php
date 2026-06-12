@extends('layouts.app')
@section('title', 'Треки - Админ-панель')
@section('content')
<section class="hero-panel"><div class="hero-kicker">Админ-панель</div><h1>Управление треками</h1></section>
<section class="section-panel">
    <div class="table-responsive"><table class="table align-middle">
        <thead><tr><th>Название</th><th>Автор</th><th>Исполнитель</th><th class="text-end">Действия</th></tr></thead>
        <tbody>
            @foreach($tracks as $track)
                <tr>
                    <td class="fw-bold">{{ $track->title }}</td><td>{{ $track->user->name ?? 'Неизвестно' }}</td><td>{{ $track->artist }}</td>
                    <td class="text-end">
                        <a href="{{ route('tracks.show', $track) }}" class="btn btn-sm btn-primary">Открыть</a>
                        <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить трек?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Удалить</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table></div>
    {{ $tracks->links() }}
</section>
@endsection
