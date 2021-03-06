<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected static $unguarded = true;

    protected $hidden = [
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        parent::saving(function ($model) {
            if (! $model->uuid) $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function accounts()
    {
        return $this->hasMany(Account::class)->oldest();
    }
}
