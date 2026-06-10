@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Загрузить трек</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cabinet.tracks.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Название трека</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Исполнитель</label>
                            <input type="text" name="artist" class="form-control" value="{{ old('artist') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Теги</label>

                            <input
                                type="text"
                                name="tags"
                                class="form-control"
                                placeholder="rock, rap, pop"
                                value="{{ old('tags') }}"
                            >

                            <small class="text-muted">
                                Указывайте теги через запятую
                            </small>
                        </div>
                        <div class="mb-3">
                            <label>Аудиофайл (MP3)</label>
                            <input type="file" name="audio" class="form-control" accept="audio/mpeg" required>
                        </div>
                        <div class="mb-3">
                            <label>Обложка (необязательно)</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Загрузить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection