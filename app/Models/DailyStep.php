<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DailyStep
 * 
 * @property int $id
 * @property int $stepCount
 * @property Carbon $day
 * @property uuid $userId
 * 
 * @property User $user
 *
 * @package App\Models
 */
class DailyStep extends Model
{
	protected $table = 'daily_steps';
	public $timestamps = false;

	protected $casts = [
		'stepCount' => 'int',
		'day' => 'datetime',
		'userId' => 'uuid'
	];

	protected $fillable = [
		'stepCount',
		'day',
		'userId'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}