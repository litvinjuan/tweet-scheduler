<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * @mixin IdeHelperAccount
 */
class Account extends Model
{
    use HasFactory;

    protected static $unguarded = true;

    protected $hidden = [
        'twitter_id',
        'twitter_token',
        'twitter_token_secret',
    ];

    protected static function boot()
    {
        parent::boot();

        parent::saving(function ($model) {
            if (! $model->uuid) $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
