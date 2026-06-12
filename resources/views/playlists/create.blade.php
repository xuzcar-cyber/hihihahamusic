@extends('layouts.app')
@section('title', 'Создать плейлист - ХиХиХа Музыка')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8"><section class="hero-panel">
    <div class="hero-kicker">Новая подборка</div><h1>Создать плейлист</h1>
    <form method="POST" action="{{ route('cabinet.playlists.store') }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-3"><label class="form-label fw-bold">Название плейлиста</label><input name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="mb-3"><label class="form-label fw-bold">Описание</label><textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea></div>
        <div class="mb-4"><label class="form-label fw-bold">Обложка</label><input name="cover" type="file" class="form-control" accept="image/*"></div>
        <button type="submit" class="btn btn-primary">Создать</button>
        <a href="{{ route('cabinet.playlists.index') }}" class="btn btn-secondary">Назад</a>
    </form>
</section></div></div>
@endsection
