<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function callback()
    {
        try {
            $twitterUser = Socialite::driver('twitter')->user();

            /** @var User $user */
            $user = User::query()->firstOrCreate([
                'twitter_id' => $twitterUser->id,
            ], [
                'nickname' => $twitterUser->nickname,
                'name' => $twitterUser->name,
                'email' => $twitterUser->email,
                'avatar_url' => $twitterUser->avatar,
            ]);

            logger($user);

            Auth::login($user);

            return redirect('/home');
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }
}
