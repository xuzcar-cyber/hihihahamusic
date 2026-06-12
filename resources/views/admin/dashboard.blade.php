@extends('layouts.app')
@section('title', 'Админ-панель - ХиХиХа Музыка')
@section('content')
<section class="hero-panel"><div class="hero-kicker">Администрирование</div><h1>Панель управления</h1><p class="lead mb-0">Ключевые показатели платформы.</p></section>
<section class="section-panel">
    <div class="row g-3">
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $usersCount }}</strong><p class="text-muted mb-0">Пользователей</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $tracksCount }}</strong><p class="text-muted mb-0">Треков</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $commentsCount }}</strong><p class="text-muted mb-0">Комментариев</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $favoritesCount }}</strong><p class="text-muted mb-0">Избранных</p></div></div></div>
        <div class="col-sm-6 col-lg"><div class="card"><div class="card-body"><strong>{{ $playlistsCount }}</strong><p class="text-muted mb-0">Плейлистов</p></div></div></div>
    </div>
    <div class="mt-4 d-flex gap-2"><a href="{{ route('admin.users') }}" class="btn btn-primary">Пользователи</a><a href="{{ route('admin.tracks') }}" class="btn btn-outline-primary">Треки</a></div>
</section>
@endsection
