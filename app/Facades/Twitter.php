<?php

namespace App\Facades;

use App\Integrations\Twitter\TwitterManager;
use Illuminate\Support\Facades\Facade;

class Twitter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TwitterManager::class;
    }
}
