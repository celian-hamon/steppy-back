<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Challenge
 *
 * @property int $id
 * @property Carbon $startAt
 * @property Carbon $endAt
 * @property int $allSteps
 * @property string $password
 * @property string $name
 * @property string $description
 *
 * @property Collection|Badge[] $badges
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Challenge extends Model
{
    use HasFactory;
	protected $table = 'challenges';
	public $timestamps = true;

	protected $casts = [
		'startAt' => 'datetime',
		'endAt' => 'datetime',
		'allSteps' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'startAt',
		'endAt',
		'password',
		'name',
		'description'
	];

	public function badges()
	{
		return $this->belongsToMany(Badge::class, 'challenge_badge', 'challengeId', 'badgeId');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'challenge_user', 'challengeId', 'userId');
	}

    public function dailySteps() {
        return $this->hasMany(DailyStep::class, 'id', 'challengeId');
    }

    public function dailyChallengeSteps() {
        return $this->hasMany(DailyChallengeStep::class, 'id', 'challengeId');
    }
}
