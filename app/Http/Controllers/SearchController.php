<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Track::query();
        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('artist', 'like', "%{$request->search}%");
        }
        $tracks = $query->paginate(20);
        return view('search.index', compact('tracks'));
    }
}