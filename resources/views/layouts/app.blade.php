<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ХиХиХа Музыка')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container app-shell">
            <a class="navbar-brand" href="{{ route('tracks.index') }}">
                <span class="brand-mark">♪</span>
                <span>ХиХиХа Музыка</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Открыть меню">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <form action="{{ route('tracks.index') }}" method="GET" class="top-search d-flex ms-lg-4 me-lg-3">
                    <input class="form-control me-2" name="search" value="{{ request('search') }}" placeholder="Найти трек, жанр или артиста">
                    <button class="btn btn-outline-light" type="submit">Найти</button>
                </form>

                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('trending') }}">Популярное</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('recent') }}">Новое</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('top-artists') }}">Топ артистов</a></li>

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Войти</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Регистрация</a></li>
                    @endguest

                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('favorites.index') }}">Избранное</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('play-history') }}">История</a></li>

                        @if(Auth::user()->is_admin)
                            <li class="nav-item"><a class="nav-link text-warning fw-bold" href="{{ route('admin.dashboard') }}">Админка</a></li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('cabinet.index') }}">Кабинет</a></li>
                                <li><a class="dropdown-item" href="{{ route('cabinet.playlists.index') }}">Плейлисты</a></li>
                                <li><a class="dropdown-item" href="{{ route('cabinet.profile.edit') }}">Профиль</a></li>

                                @if(Auth::user()->is_admin)
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-warning" href="{{ route('admin.dashboard') }}">Панель администратора</a></li>
                                @endif

                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Выйти</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container app-shell">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <div class="floating-player" id="floatingPlayer">
        <div class="player-track-info">
            <img class="player-cover" id="playerCover" src="https://via.placeholder.com/120" alt="Обложка трека">
            <div class="player-details">
                <p class="player-title" id="playerTitle">Выберите трек</p>
                <p class="player-artist" id="playerArtist">Артист</p>
            </div>
        </div>
        <div class="player-actions d-flex align-items-center gap-2">
            <button class="player-btn" id="playerPrev" onclick="playerPrevious()" aria-label="Предыдущий трек">‹</button>
            <button class="player-btn play" id="playerPlayBtn" onclick="playerTogglePlay()">Играть</button>
            <button class="player-btn" id="playerNext" onclick="playerNext()" aria-label="Следующий трек">›</button>
            <div class="player-progress" id="playerProgress" onclick="playerSeek(event)">
                <div class="player-progress-bar" id="playerProgressBar"></div>
            </div>
            <span class="player-time" id="playerTime">0:00</span>
            <button class="player-btn" id="playerClose" onclick="playerClose()" aria-label="Закрыть плеер">×</button>
        </div>
    </div>
    <audio id="audioElement"></audio>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentTrack = null;
        let isPlaying = false;

        function playTrack(trackId, audioUrl, title, artist, coverUrl) {
            const audio = document.getElementById('audioElement');
            const player = document.getElementById('floatingPlayer');

            currentTrack = { trackId, audioUrl, title, artist, coverUrl };

            document.getElementById('playerTitle').textContent = title;
            document.getElementById('playerArtist').textContent = artist;
            document.getElementById('playerCover').src = coverUrl;

            audio.src = audioUrl;
            audio.play();
            isPlaying = true;

            player.classList.add('active');
            updatePlayButton();

            fetch(`/tracks/${trackId}/play`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content },
                body: JSON.stringify({ seconds_played: 0 })
            }).catch(() => {});

            audio.addEventListener('timeupdate', updateProgress);
            audio.addEventListener('ended', playerNext);
        }

        function playerTogglePlay() {
            const audio = document.getElementById('audioElement');
            if (isPlaying) {
                audio.pause();
                isPlaying = false;
            } else {
                audio.play();
                isPlaying = true;
            }
            updatePlayButton();
        }

        function updatePlayButton() {
            const btn = document.getElementById('playerPlayBtn');
            btn.textContent = isPlaying ? 'Пауза' : 'Играть';
        }

        function updateProgress() {
            const audio = document.getElementById('audioElement');
            const bar = document.getElementById('playerProgressBar');
            const time = document.getElementById('playerTime');

            if (audio.duration) {
                const percent = (audio.currentTime / audio.duration) * 100;
                bar.style.width = percent + '%';
                time.textContent = formatTime(audio.currentTime);
            }
        }

        function playerSeek(e) {
            const audio = document.getElementById('audioElement');
            const progress = document.getElementById('playerProgress');
            const percent = e.offsetX / progress.offsetWidth;
            audio.currentTime = percent * audio.duration;
        }

        function playerClose() {
            const audio = document.getElementById('audioElement');
            const player = document.getElementById('floatingPlayer');
            audio.pause();
            isPlaying = false;
            player.classList.remove('active');
            currentTrack = null;
        }

        function playerNext() {}
        function playerPrevious() {}

        function formatTime(seconds) {
            if (!seconds || isNaN(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }
    </script>
</body>
</html>
