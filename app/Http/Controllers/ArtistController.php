<?php

namespace App\Http\Controllers;

use App\Models\User;

class ArtistController extends Controller
{
    public function show(User $user)
    {
        $tracks = $user->tracks()
            ->latest()
            ->paginate(12);

        return view('artist.show', compact(
            'user',
            'tracks'
        ));
    }
}