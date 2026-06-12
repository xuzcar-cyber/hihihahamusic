@extends('layouts.app')
@section('title', 'ХиХиХа Музыка')
@section('content')
<section class="hero-panel">
    <div class="hero-kicker">Добро пожаловать</div>
    <h1>ХиХиХа Музыка</h1>
    <p class="lead">Откройте главную витрину, чтобы слушать треки, искать артистов и собирать плейлисты.</p>
    <a href="{{ route('tracks.index') }}" class="btn btn-primary">Перейти к музыке</a>
</section>
@endsection
