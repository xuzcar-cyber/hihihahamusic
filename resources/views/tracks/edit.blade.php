@extends('layouts.app')
@section('title', 'Редактировать трек - ХиХиХа Музыка')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <section class="hero-panel">
            <div class="hero-kicker">Настройки релиза</div>
            <h1>Редактировать трек</h1>
            <form method="POST" action="{{ route('cabinet.tracks.update', $track) }}" enctype="multipart/form-data" class="mt-4">
                @csrf @method('PUT')
                <div class="mb-3"><label class="form-label fw-bold">Название</label><input name="title" class="form-control" value="{{ old('title', $track->title) }}" required></div>
                <div class="mb-3"><label class="form-label fw-bold">Исполнитель</label><input name="artist" class="form-control" value="{{ old('artist', $track->artist) }}" required></div>
                <div class="mb-3"><label class="form-label fw-bold">Жанр</label><input name="genre" class="form-control" value="{{ old('genre', $track->genre) }}"></div>
                <div class="mb-3"><label class="form-label fw-bold">Заменить аудио</label><input name="audio" type="file" class="form-control" accept=".mp3,.wav,audio/*"></div>
                <div class="mb-4"><label class="form-label fw-bold">Заменить обложку</label><input name="cover" type="file" class="form-control" accept="image/*"></div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('cabinet.index') }}" class="btn btn-secondary">Назад</a>
            </form>
        </section>
    </div>
</div>
@endsection
