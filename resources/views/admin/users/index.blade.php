@extends('layouts.app')
@section('title', 'Пользователи - Админ-панель')
@section('content')
<section class="hero-panel"><div class="hero-kicker">Админ-панель</div><h1>Пользователи</h1></section>
<section class="section-panel">
    <div class="table-responsive"><table class="table align-middle">
        <thead><tr><th>Имя</th><th>Email</th><th>Администратор</th><th class="text-end">Действия</th></tr></thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="fw-bold">{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->is_admin ? 'Да' : 'Нет' }}</td>
                    <td class="text-end">
                        @unless($user->is_admin)
                            <form action="{{ route('admin.users.make-admin', $user) }}" method="POST">@csrf<button class="btn btn-sm btn-warning">Сделать админом</button></form>
                        @endunless
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table></div>
    {{ $users->links() }}
</section>
@endsection
