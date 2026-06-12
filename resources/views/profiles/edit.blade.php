@extends('layouts.app')
@section('title', 'Редактировать профиль - ХиХиХа Музыка')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <section class="hero-panel">
            <div class="hero-kicker">Профиль</div>
            <h1>Редактировать профиль</h1>
            <form method="POST" action="{{ route('cabinet.profile.update') }}" enctype="multipart/form-data" class="mt-4">
                @csrf @method('PUT')
                <div class="mb-3"><label class="form-label fw-bold">Имя</label><input name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
                <div class="mb-3"><label class="form-label fw-bold">Email</label><input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
                <div class="mb-3"><label class="form-label fw-bold">Описание</label><textarea name="bio" class="form-control" rows="4">{{ old('bio', $user->bio) }}</textarea></div>
                <div class="mb-4"><label class="form-label fw-bold">Аватар</label><input name="avatar" type="file" class="form-control" accept="image/*"></div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('cabinet.index') }}" class="btn btn-secondary">Назад</a>
            </form>
        </section>
    </div>
</div>
@endsection
