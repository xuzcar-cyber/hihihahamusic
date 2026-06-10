<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tracks = $user->tracks()->latest()->paginate(10);

        return view('cabinet.index', compact('user', 'tracks'));
    }
}