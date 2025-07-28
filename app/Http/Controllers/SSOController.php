<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class SSOController extends Controller
{
    public function loginViaToken(Request $request)
    {
        $token = $request->query('token');
        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return redirect('/login')->withErrors(['email' => 'Invalid SSO token']);
        }

        $user = $accessToken->tokenable;
        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
