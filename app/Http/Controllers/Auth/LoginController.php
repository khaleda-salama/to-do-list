<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $validated = $request->safe()->all();

        if (! Auth::attempt($validated)) {
            return back()
                ->withErrors(['password' => 'We were unabel to authenticate using the provided credentials'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended(route('idea.index'))->with('success', 'You are now logged in.');

    }
}
