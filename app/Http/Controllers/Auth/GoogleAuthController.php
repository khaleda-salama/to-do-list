<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            report($e);

            return to_route('login')->with('error', 'Google sign-in failed. Please try again.');
        }

        if (! $googleUser || ! $googleUser->getId() || ! $googleUser->getEmail()) {
            return to_route('login')->with('error', 'Google sign-in failed. Please try again.');
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (! $user) {
            try {
                $user = User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(40)),
                ]);
            } catch (QueryException $e) {
                if ($e->getCode() !== '23000' && ! str_contains($e->getMessage(), 'Duplicate entry')) {
                    throw $e;
                }

                $user = User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();
            }
        }

        if (! $user) {
            return to_route('login')->with('error', 'Google sign-in failed. Please try again.');
        }

        if (! $user->google_id) {
            $user->google_id = $googleUser->getId();
            $user->save();
        }

        Auth::login($user);

        if (! $user->wasRecentlyCreated) {
            $request->session()->regenerate();
        }

        return to_route('idea.index')->with('success', $user->wasRecentlyCreated ? 'Registration complete, You can set a new password anytime from your profile' : 'You are now logged in.');

    }
}
