<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use Illuminate\Support\Facades\Storage;

class UploadTest extends Controller
{
    public function form() {
        return view('test-upload');
    }

    public function store(Request $request) {
        $request->validate(['audio' => 'required|file|mimes:mp3']);

        $path = $request->file('audio')->store('tracks', 'public');
        $track = Track::create([
            'user_id' => 1, // замените на ID существующего пользователя
            'title' => 'Test',
            'artist' => 'Test',
            'file_path' => Storage::url($path),
        ]);

        return 'Трек сохранён, ID: ' . $track->id;
    }
}