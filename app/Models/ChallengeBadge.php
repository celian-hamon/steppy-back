<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChallengeBadge
 * 
 * @property int $challengeId
 * @property int $badgeId
 * 
 * @property Challenge $challenge
 * @property Badge $badge
 *
 * @package App\Models
 */
class ChallengeBadge extends Model
{
	protected $table = 'challenge_badge';
	protected $primaryKey = 'challengeId';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'challengeId' => 'int',
		'badgeId' => 'int'
	];

	protected $fillable = [
		'badgeId'
	];

	public function challenge()
	{
		return $this->belongsTo(Challenge::class, 'challengeId');
	}

	public function badge()
	{
		return $this->belongsTo(Badge::class, 'badgeId');
	}
}
