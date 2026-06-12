@extends('layouts.app')

@section('title', 'Регистрация - ХиХиХа Музыка')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">
        <section class="hero-panel">
            <div class="hero-kicker">Новый профиль</div>
            <h1 class="mb-3">Регистрация</h1>
            <p class="lead">Создайте аккаунт, чтобы загружать треки, добавлять избранное и собирать свои плейлисты.</p>

            <form method="POST" action="{{ route('register') }}" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Имя</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Пароль</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Подтверждение пароля</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                    <a href="{{ route('login') }}" class="btn btn-link">Уже есть аккаунт? Войдите</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
