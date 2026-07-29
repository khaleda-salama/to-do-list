<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'email' => ['string', 'required', 'email', 'max:255'],
            'password' => ['string', 'required', 'max:255', Password::default()],
        ]);

        if (! Auth::attempt($validate)) {
            return back()
                ->withErrors(['password' => 'We were unabel to authenticate using the provided credentials'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended(route('idea.index'))->with('success', 'You are now logged in.');

    }
}
