@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                Мои плейлисты
                <a href="{{ route('cabinet.playlists.create') }}" class="btn btn-success btn-sm">+ Создать плейлист</a>
            </div>
            <div class="card-body">
                @if($playlists->count())
                    <div class="row">
                        @foreach($playlists as $playlist)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px; position: relative;">
                                        @if($playlist->cover_path)
                                            <img src="{{ Storage::disk('public')->url($playlist->cover_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: white; font-size: 48px;">
                                                📋
                                            </div>
                                        @endif
                                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.5); padding: 10px; color: white;">
                                            <strong>{{ $playlist->tracks_count }}</strong> треков
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5><a href="{{ route('cabinet.playlists.show', $playlist) }}">{{ $playlist->name }}</a></h5>
                                        <p class="text-muted small">{{ Str::limit($playlist->description, 60) }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('cabinet.playlists.show', $playlist) }}" class="btn btn-sm btn-primary">Смотреть</a>
                                        <a href="{{ route('cabinet.playlists.edit', $playlist) }}" class="btn btn-sm btn-warning">Изменить</a>
                                        <form action="{{ route('cabinet.playlists.destroy', $playlist) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить плейлист?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $playlists->links() }}
                @else
                    <p class="text-muted">У вас пока нет плейлистов. <a href="{{ route('cabinet.playlists.create') }}">Создайте первый!</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
