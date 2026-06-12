@extends('layouts.app')
@section('title', 'Загрузить трек - ХиХиХа Музыка')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <section class="hero-panel">
            <div class="hero-kicker">Новый релиз</div>
            <h1>Загрузить трек</h1>
            <form method="POST" action="{{ route('cabinet.tracks.store') }}" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="mb-3"><label class="form-label fw-bold">Название трека</label><input name="title" class="form-control" value="{{ old('title') }}" required></div>
                <div class="mb-3"><label class="form-label fw-bold">Исполнитель</label><input name="artist" class="form-control" value="{{ old('artist', auth()->user()->name ?? '') }}" required></div>
                <div class="mb-3"><label class="form-label fw-bold">Жанр</label><input name="genre" class="form-control" value="{{ old('genre') }}" placeholder="Например: поп, рок, электроника"></div>
                <div class="mb-3"><label class="form-label fw-bold">Аудиофайл (MP3 или WAV)</label><input name="audio" type="file" class="form-control" accept=".mp3,.wav,audio/*" required></div>
                <div class="mb-4"><label class="form-label fw-bold">Обложка</label><input name="cover" type="file" class="form-control" accept="image/*"></div>
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </section>
    </div>
</div>
@endsection
