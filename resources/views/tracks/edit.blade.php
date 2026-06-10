@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Редактировать трек</div>
            <div class="card-body">
                <form method="POST" action="{{ route('cabinet.tracks.update', $track) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Название</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $track->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Исполнитель</label>
                        <input type="text" name="artist" class="form-control" value="{{ old('artist', $track->artist) }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Жанр</label>
                        <input type="text" name="genre" class="form-control" value="{{ old('genre', $track->genre) }}">
                    </div>
                    <div class="mb-3">
                        <label>Обложка (необязательно)</label>
                        <input type="file" name="cover" class="form-control" accept="image/*">
                        @if($track->cover_url)
                            <img src="{{ $track->cover_url }}" width="100" class="mt-2">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
