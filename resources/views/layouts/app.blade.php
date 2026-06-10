<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            padding-top: 70px; 
            padding-bottom: 100px;
        }
        
        .floating-player {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            color: white;
        }
        
        .floating-player.active {
            transform: translateY(0);
        }
        
        .player-track-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            min-height: 50px;
        }
        
        .player-cover {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            object-fit: cover;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .player-details {
            flex: 1;
            min-width: 0;
        }
        
        .player-title {
            font-weight: 600;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .player-artist {
            font-size: 0.9em;
            opacity: 0.8;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .player-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }
        
        .player-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .player-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .player-btn.play {
            background: #1db954;
            padding: 10px 15px;
        }
        
        .player-btn.play:hover {
            background: #1ed760;
        }
        
        .player-progress {
            flex: 1;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            cursor: pointer;
            margin: 0 10px;
        }
        
        .player-progress-bar {
            height: 100%;
            background: #1db954;
            border-radius: 2px;
            width: 0%;
            transition: width 0.1s linear;
        }
        
        .player-time {
            font-size: 0.85em;
            opacity: 0.8;
            min-width: 45px;
        }
        
        .play-btn-inline {
            padding: 6px 12px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tracks.index') }}">🎵 Музыкальная платформа</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form action="{{ route('tracks.index') }}" method="GET" class="d-flex ms-auto me-3">
                    <input class="form-control me-2" name="search" value="{{ request('search') }}" placeholder="Поиск треков...">
                    <button class="btn btn-outline-light">Найти</button>
                </form>
                
               <ul class="navbar-nav ms-auto">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('trending') }}">
            🔥 Популярное
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('recent') }}">
            ✨ Новое
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('top-artists') }}">
            ⭐ Топ артистов
        </a>
    </li>

    {{-- ГОСТЬ --}}
    @guest

        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">
                Войти
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">
                Регистрация
            </a>
        </li>

    @endguest

    {{-- АВТОРИЗОВАННЫЙ ПОЛЬЗОВАТЕЛЬ --}}
    @auth

        <li class="nav-item">
            <a class="nav-link" href="{{ route('favorites.index') }}">
                ❤️ Избранное
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('play-history') }}">
                📝 История
            </a>
        </li>

        {{-- ТОЛЬКО АДМИН --}}
        @if(Auth::user()->is_admin)

            <li class="nav-item">
                <a class="nav-link text-warning fw-bold"
                   href="{{ route('admin.dashboard') }}">
                    ⚙ Админка
                </a>
            </li>

        @endif

        <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle"
               href="#"
               role="button"
               data-bs-toggle="dropdown">

                👤 {{ Auth::user()->name }}

            </a>

            <ul class="dropdown-menu">

                <li>
                    <a class="dropdown-item"
                       href="{{ route('cabinet.index') }}">
                        Кабинет
                    </a>
                </li>

                <li>
                    <a class="dropdown-item"
                       href="{{ route('cabinet.playlists.index') }}">
                        Плейлисты
                    </a>
                </li>

                <li>
                    <a class="dropdown-item"
                       href="{{ route('cabinet.profile.edit') }}">
                        Профиль
                    </a>
                </li>

                @if(Auth::user()->is_admin)

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item text-warning"
                           href="{{ route('admin.dashboard') }}">
                            ⚙ Панель администратора
                        </a>
                    </li>

                @endif

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <form method="POST"
                          action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="dropdown-item">
                            Выход
                        </button>
                    </form>
                </li>

            </ul>

        </li>

    @endauth

</ul>
            </div>
        </div>
    </nav>
    <div class="container">
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
    </div>

    <!-- Floating Player -->
    <div class="floating-player" id="floatingPlayer">
        <div class="player-track-info">
            <img class="player-cover" id="playerCover" src="https://via.placeholder.com/50" alt="Cover">
            <div class="player-details">
                <p class="player-title" id="playerTitle">Выберите трек</p>
                <p class="player-artist" id="playerArtist">Исполнитель</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="player-btn" id="playerPrev" onclick="playerPrevious()">⏮ Пред</button>
            <button class="player-btn play" id="playerPlayBtn" onclick="playerTogglePlay()">▶ Играть</button>
            <button class="player-btn" id="playerNext" onclick="playerNext()">Далее ⏭</button>
            <div class="player-progress" id="playerProgress" onclick="playerSeek(event)">
                <div class="player-progress-bar" id="playerProgressBar"></div>
            </div>
            <span class="player-time" id="playerTime">0:00</span>
            <button class="player-btn" id="playerClose" onclick="playerClose()">✕</button>
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
            
            // Record play
            fetch(`/tracks/${trackId}/play`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content },
                body: JSON.stringify({ seconds_played: 0 })
            }).catch(e => console.log('Play recorded'));
            
            // Update progress
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
            btn.textContent = isPlaying ? '⏸ Пауза' : '▶ Играть';
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

        function playerNext() {
            console.log('Next track');
        }

        function playerPrevious() {
            console.log('Previous track');
        }

        function formatTime(seconds) {
            if (!seconds || isNaN(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        // Add CSRF token to meta
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }
    </script>
</body>
</html>