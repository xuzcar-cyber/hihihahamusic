@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Редактировать плейлист</div>
            <div class="card-body">
                <form method="POST" action="{{ route('cabinet.playlists.update', $playlist) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Название плейлиста</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $playlist->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Описание</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $playlist->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Обложка (необязательно)</label>
                        <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($playlist->cover_path)
                            <img src="{{ Storage::disk('public')->url($playlist->cover_path) }}" width="100" class="mt-2">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="{{ route('cabinet.playlists.show', $playlist) }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
