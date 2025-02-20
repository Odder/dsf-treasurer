<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class WcaAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('wca')->redirect();
    }

    public function handleProviderCallback()
    {
        $wcaUser = Socialite::driver('wca')->stateless()->user();

        // Check if a user with this WCA ID already exists
        $user = User::where('wca_id', $wcaUser->wca_id)->first();

        if ($user) {
            Auth::login($user);
            return redirect('/invoices');
        }

        // Check if a user with this email already exists
        $user = User::where('email', $wcaUser->email)->first();

        if ($user) {
            //merge
            $user->wca_id = $wcaUser->wca_id;
            $user->save();
            Auth::login($user);
            return redirect('/invoices');
        }

        // Create a new user
        $newUser = User::create([
            'name' => $wcaUser->name,
            'email' => $wcaUser->email,
            'wca_id' => $wcaUser->wca_id,
            'password' => Hash::make(Str::random(40)), // Generate a random password
        ]);

        Auth::login($newUser);

        return redirect('/dashboard');
    }
}
