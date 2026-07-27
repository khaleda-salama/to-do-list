<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UserProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserProfileRequest $request)
    {
        $user = Auth::user();

        $originalEmail = $user->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ?? $user->password,
        ]);

        // If The Email Was Changed, Send an  EmailChanged::class Notification
        if ($originalEmail !== $request->email) {

            Notification::route('mail', $originalEmail)
                ->notify(new EmailChanged($user, $originalEmail));

        }

        return redirect(route('profile.edit'))->with('success', 'Your Profile Is Updated!');
    }
}
