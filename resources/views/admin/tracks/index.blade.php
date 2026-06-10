@extends('layouts.app')

@section('content')

<h1>Управление треками</h1>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Автор</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    @foreach($tracks as $track)
        <tr>
            <td>{{ $track->id }}</td>
            <td>{{ $track->title }}</td>
            <td>{{ $track->user->name ?? 'Неизвестно' }}</td>

            <td>
                <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm">
                        Удалить
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $tracks->links() }}

@endsection