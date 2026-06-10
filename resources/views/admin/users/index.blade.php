@extends('layouts.app')

@section('content')

<h1>Пользователи</h1>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Админ</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->is_admin ? 'Да' : 'Нет' }}</td>

            <td>
                @unless($user->is_admin)
                    <form action="{{ route('admin.users.make-admin', $user) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning btn-sm">
                            Сделать админом
                        </button>
                    </form>
                @endunless
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $users->links() }}

@endsection