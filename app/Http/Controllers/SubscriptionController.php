<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function toggle(User $user)
    {
        if ($user->id === Auth::id()) {
            return back();
        }

        /** @var User $currentUser */
        $currentUser = Auth::user();
        $existing = $currentUser->followings()->where('followed_id', $user->id);

        if ($existing->exists()) {
            $existing->detach();
        } else {
            $currentUser->followings()->attach($user->id);
        }

        return back()->with('success', $existing->exists() ? 'Вы отписались' : 'Вы подписались');
    }
}