<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Account;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function loginScreen()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->only(['email', 'password']), $request->boolean('remember'))) {
            throw ValidationException::withMessages(['password' => "Credentials don't match"]);
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth.login');
    }

    public function redirect()
    {
        config(['services.twitter.redirect' => route('auth.callback')]);
        return Socialite::driver('twitter')->redirect();
    }

    public function callback()
    {
        try {
            $twitterUser = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return redirect()->route('auth.login');
        }

        /** @var Account $account */
        $account = Account::query()->with('user')->where('twitter_id', $twitterUser->getId())->first();

        if ($account) {
            $account->update([
                'username' => $twitterUser->getNickname(),
                'name' => $twitterUser->getName(),
                'avatar_url' => $twitterUser->getAvatar(),
                'twitter_token' => $twitterUser->token,
                'twitter_token_secret' => $twitterUser->tokenSecret,
            ]);

            $user = $account->user;
        } else {
            /** @var User $user */
            $user = User::query()->create([
                'email' => $twitterUser->getEmail(),
                'name' => $twitterUser->getName(),
                'password' => null,
            ]);

            $account = $user->accounts()->create([
                'name' => $twitterUser->getName(),
                'username' => $twitterUser->getNickname(),
                'avatar_url' => $twitterUser->getAvatar(),
                'twitter_id' => $twitterUser->getId(),
                'twitter_token' => $twitterUser->token,
                'twitter_token_secret' => $twitterUser->tokenSecret,
            ]);
        }

        Auth::login($user, true);

        return redirect()->route('dashboard', ['account' => $account]);
    }
}
