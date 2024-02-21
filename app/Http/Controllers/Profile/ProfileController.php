<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($user->email == $request->email) {
            $request->validate([
                'name' => ['required', 'string', 'max:14'],
            ]);
            $user->name = $request->name;
            $user->email = $request->email;

            $user->update();

            return back();
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:14'],
                'email' => ['required', 'string', 'max:255', 'unique:users'],
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->email_verified_at = null;

            $user->update();

            return redirect()->route('verification.notice');
        }
    }
}
