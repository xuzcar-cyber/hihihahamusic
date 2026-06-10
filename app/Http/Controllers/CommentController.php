<?php
namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
    public function store(Request $request, Track $track) {
        $request->validate(['body' => 'required|string|max:1000']);
        $track->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);
        return back();
    }
}