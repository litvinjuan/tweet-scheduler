<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class AccountController extends Controller
{
    public function index()
    {
        return \Auth::user()->accounts;
    }

    public function switch(Account $account)
    {
        return redirect()->route('dashboard', ['account' => $account]);
    }

    public function redirect()
    {
        config(['services.twitter.redirect' => route('accounts.callback')]);
        return Socialite::driver('twitter')->redirect();
    }

    public function callback()
    {
        try {
            $twitterUser = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return redirect()->route('accounts.index');
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
        } else {
            $account = \Auth::user()->accounts()->create([
                'name' => $twitterUser->getName(),
                'username' => $twitterUser->getNickname(),
                'avatar_url' => $twitterUser->getAvatar(),
                'twitter_id' => $twitterUser->getId(),
                'twitter_token' => $twitterUser->token,
                'twitter_token_secret' => $twitterUser->tokenSecret,
            ]);
        }

        return redirect()->route('dashboard', ['account' => $account]);
    }
}
