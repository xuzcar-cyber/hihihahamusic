@extends('layouts.app')
@section('title', 'Редактировать плейлист - ХиХиХа Музыка')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8"><section class="hero-panel">
    <div class="hero-kicker">Настройки подборки</div><h1>Редактировать плейлист</h1>
    <form method="POST" action="{{ route('cabinet.playlists.update', $playlist) }}" enctype="multipart/form-data" class="mt-4">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label fw-bold">Название плейлиста</label><input name="name" class="form-control" value="{{ old('name', $playlist->name) }}" required></div>
        <div class="mb-3"><label class="form-label fw-bold">Описание</label><textarea name="description" class="form-control" rows="4">{{ old('description', $playlist->description) }}</textarea></div>
        <div class="mb-4"><label class="form-label fw-bold">Новая обложка</label><input name="cover" type="file" class="form-control" accept="image/*"></div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('cabinet.playlists.show', $playlist) }}" class="btn btn-secondary">Назад</a>
    </form>
</section></div></div>
@endsection
