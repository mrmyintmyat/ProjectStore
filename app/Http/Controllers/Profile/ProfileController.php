<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $chatIdSelection = $request->input('select_chat_id');
        $chatIdValue = $request->input('chat_id');

        // Ensure chat_id selection is one of the expected values
        if (!in_array($chatIdSelection, ['messenger', 'telegram', 'skype', 'whatsapp', 'viber'])) {
            return back()
                ->withErrors(['select_chat_id' => 'Invalid chat platform selection'])
                ->withInput();
        }

        // Combine the chat_id selection and value into an associative array
        $chatIdData = [
            $chatIdSelection => $chatIdValue,
        ];

        if ($user->email == $request->email) {
            $request->validate([
                'name' => ['required', 'string', 'max:14'],
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->chat_id = $chatIdData;
            $user->update();

            return back()->with(['status' => 'Success']);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:14'],
                'email' => ['required', 'string', 'max:255', 'unique:users'],
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->chat_id = $chatIdData;
            $user->email_verified_at = null;
            $user->update();

            return redirect()->route('verification.notice');
        }
    }
}
