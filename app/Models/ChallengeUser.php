<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChallengeUser
 * 
 * @property int $challengeId
 * @property uuid $userId
 * 
 * @property Challenge $challenge
 * @property User $user
 *
 * @package App\Models
 */
class ChallengeUser extends Model
{
	protected $table = 'challenge_user';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'challengeId' => 'int',
		'userId' => 'uuid'
	];

	protected $fillable = [
		'challengeId',
		'userId'
	];

	public function challenge()
	{
		return $this->belongsTo(Challenge::class, 'challengeId');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}
