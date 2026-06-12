@extends('layouts.app')
@section('title', 'Тест загрузки - ХиХиХа Музыка')
@section('content')
<section class="hero-panel">
    <div class="hero-kicker">Проверка</div>
    <h1>Тест загрузки</h1>
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control mb-3">
        <button class="btn btn-primary">Загрузить</button>
    </form>
</section>
@endsection
