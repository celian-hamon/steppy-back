<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DailyChallengeStep
 *
 * @property int $id
 * @property int $stepCount
 * @property Carbon $day
 * @property int $challengeId
 *
 * @package App\Models
 */
class DailyChallengeStep extends Model
{
    use HasFactory;
	protected $table = 'daily_challenge_steps';
	public $timestamps = false;

	protected $casts = [
		'stepCount' => 'int',
		'day' => 'datetime',
		'challengeId' => 'int'
	];

	protected $fillable = [
		'stepCount',
		'day',
		'challengeId'
	];
}
