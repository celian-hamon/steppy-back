<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * //  * @property uuid $id
 * @property int $avatarId
 * @property int $age
 * @property string $sexe
 * @property int $jobId
 * @property bool $shareData
 * @property string $code
 * @property Carbon|null $last_login
 * @property bool $isAdmin
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Avatar $avatar
 * @property Collection|Challenge[] $challenges
 * @property Collection|Badge[] $badges
 * @property Collection|DailyStep[] $daily_steps
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    public $incrementing = true;

    protected $casts = [
        'avatarId' => 'int',
        'age' => 'int',
        'shareData' => 'bool',
        'last_login' => 'datetime',
        'isAdmin' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'id',
        'avatarId',
        'age',
        'sexe',
        'shareData',
        'code',
        'last_login',
        'isAdmin',
        'password',
        'remember_token'
    ];

    public function avatar()
    {
        return $this->belongsTo(Avatar::class, 'avatarId');
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'challenge_user', 'userId', 'challengeId');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badge', 'userId', 'badgeId');
    }

    public function daily_steps()
    {
        return $this->hasMany(DailyStep::class, 'userId');
    }
}
