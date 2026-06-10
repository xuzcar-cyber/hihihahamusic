@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Редактировать профиль</div>
            <div class="card-body">
                <form method="POST" action="{{ route('cabinet.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Имя</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Биография</label>
                        <textarea name="bio" class="form-control" rows="3">{{ old('bio', auth()->user()->bio) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Аватар</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection