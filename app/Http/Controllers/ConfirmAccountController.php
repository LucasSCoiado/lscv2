<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($token)
    {
        $user = User::where('token', $token)->first();

        if (!$user) {
            abort(403, 'Invalid confirmation token');
        }

        return view('auth.confirm-account', compact('user'));
    }

    public function confirmAcountSubmit(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:60',
        ]);

        $user = User::where('token', $request->token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Token inválido ou expirado.');
        }

        $user->token = null;
        $user->email_verified_at = now();
        $user->save();

        // loga o usuário para que Auth::user() exista na view
        Auth::login($user);

        return view('auth.new_user_confirmation', compact('user'));
    }
}
