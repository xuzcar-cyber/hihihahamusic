<?php
use App\Http\Controllers\TrackController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ArtistController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [TrackController::class, 'index'])->name('tracks.index');
Route::get('/tracks/{track}', [TrackController::class, 'show'])->name('tracks.show');
Route::post('/tracks/{track}/like', [LikeController::class, 'toggle'])->name('tracks.like')->middleware('auth');
Route::post('/tracks/{track}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/users/{user}/subscribe', [SubscriptionController::class, 'toggle'])->name('subscribe.toggle')->middleware('auth');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile');

// Statistics and Discovery
Route::get('/trending', [StatisticsController::class, 'trending'])->name('trending');
Route::get('/recent', [StatisticsController::class, 'recent'])->name('recent');
Route::get('/top-artists', [StatisticsController::class, 'topArtists'])->name('top-artists');
Route::post('/tracks/{track}/play', [StatisticsController::class, 'recordPlay'])->name('tracks.record-play')->middleware('auth');
Route::post('/tracks/{track}/view', [StatisticsController::class, 'recordView'])->name('tracks.record-view');

// Favorites
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/tracks/{track}/favorite', [FavoriteController::class, 'toggle'])->name('tracks.favorite');
    Route::get('/play-history', [StatisticsController::class, 'playHistory'])->name('play-history');
});

Route::middleware('auth')->prefix('cabinet')->name('cabinet.')->group(function () {
    Route::get('/', [CabinetController::class, 'index'])->name('index');
    Route::get('/tracks/create', [TrackController::class, 'create'])->name('tracks.create');
    Route::post('/tracks', [TrackController::class, 'store'])->name('tracks.store');
    Route::get('/tracks/{track}/edit', [TrackController::class, 'edit'])->name('tracks.edit');
    Route::put('/tracks/{track}', [TrackController::class, 'update'])->name('tracks.update');
    Route::delete('/tracks/{track}', [TrackController::class, 'destroy'])->name('tracks.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Playlists
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
    Route::post('/playlists/{playlist}/remove-track', [PlaylistController::class, 'removeTrack'])->name('playlists.remove-track');
    Route::post('/playlists/{playlist}/tracks/{track}',[PlaylistController::class, 'addTrack'])->name('playlists.add-track');
});

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');

        Route::get('/tracks', [AdminController::class, 'tracks'])
            ->name('tracks');

        Route::delete('/tracks/{track}', [AdminController::class, 'destroyTrack'])
            ->name('tracks.destroy');

        Route::post('/users/{user}/make-admin', [AdminController::class, 'makeAdmin'])
            ->name('users.make-admin');
    });

    Route::get('/artist/{user}', [ArtistController::class, 'show'])
    ->name('artist.show');