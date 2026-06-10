@extends('layouts.app')

@section('content')

<h1 class="mb-4">Админ-панель</h1>

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h2>{{ $usersCount }}</h2>
                <p>Пользователей</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h2>{{ $tracksCount }}</h2>
                <p>Треков</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h2>{{ $commentsCount }}</h2>
                <p>Комментариев</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h2>{{ $playlistsCount }}</h2>
                <p>Плейлистов</p>
            </div>
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="{{ route('admin.users') }}" class="btn btn-primary">
        Пользователи
    </a>

    <a href="{{ route('admin.tracks') }}" class="btn btn-success">
        Треки
    </a>
</div>

@endsection