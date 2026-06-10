<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(User $user) {
        $tracks = $user->tracks()->latest()->paginate(10);
        return view('profiles.show', compact('user', 'tracks'));
    }
    public function edit() { return view('profiles.edit', ['user' => Auth::user()]); }
    public function update(Request $request) {
        /** @var User $user */
        $user = Auth::user();
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users,email,'.$user->id, 'bio' => 'nullable', 'avatar' => 'nullable|image|max:10240']);
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->save();
        return redirect()->route('cabinet.index')->with('success', 'Профиль обновлён');
    }
}