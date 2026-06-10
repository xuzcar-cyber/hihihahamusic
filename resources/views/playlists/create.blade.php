@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Создать плейлист</div>
            <div class="card-body">
                <form method="POST" action="{{ route('cabinet.playlists.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Название плейлиста</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Описание</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Обложка (необязательно)</label>
                        <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Создать</button>
                    <a href="{{ route('cabinet.playlists.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
