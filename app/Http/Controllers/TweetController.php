<?php

namespace App\Http\Controllers;

use App\Facades\Twitter;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class TweetController extends Controller
{
    public function index(Account $account)
    {
//        $tweets = Twitter::getUserTimeline($account);

        return Inertia::render('Dashboard', [
            'tweets' => [],//$tweets['tweets'],
            'paginationToken' => '', //$tweets['paginationToken'],
        ]);
    }

    public function store(Request $request)
    {
        try {
            Twitter::tweet($request->user(), $request->input('body'));

            return back();
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['generic' => $exception->getMessage()]);
        }
    }
}
