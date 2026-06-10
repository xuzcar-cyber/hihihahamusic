<?php
namespace App\Http\Controllers;
use App\Models\Track;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller {
    public function toggle(Track $track) {
        $like = $track->likes()->where('user_id', Auth::id())->first();
        if ($like) {
            $like->delete();
            $track->decrement('likes_count');
        } else {
            $track->likes()->create(['user_id' => Auth::id()]);
            $track->increment('likes_count');
        }
        return back();
    }
}