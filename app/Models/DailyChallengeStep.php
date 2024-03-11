<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
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
	protected $table = 'daily_challenge_steps';
	public $timestamps = true;

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
