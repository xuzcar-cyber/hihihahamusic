@extends('layouts.app')

@section('title', 'Вход - ХиХиХа Музыка')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">
        <section class="hero-panel">
            <div class="hero-kicker">С возвращением</div>
            <h1 class="mb-3">Войти</h1>
            <p class="lead">Продолжайте слушать любимые треки, собирать плейлисты и следить за артистами.</p>

            <form method="POST" action="{{ route('login') }}" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
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

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="submit" class="btn btn-primary">Войти</button>
                    <a href="{{ route('register') }}" class="btn btn-link">Нет аккаунта? Зарегистрируйтесь</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
