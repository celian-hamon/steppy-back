<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Doctrine\DBAL\Types\BigIntType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserBadge
 * 
 * @property BigIntType $userId
 * @property int $badgeId
 * 
 * @property User $user
 * @property Badge $badge
 *
 * @package App\Models
 */
class UserBadge extends Model
{
	protected $table = 'user_badge';
	public $incrementing = false;
	public $timestamps = true;

	protected $casts = [
		'userId' => 'bigint',
		'badgeId' => 'int'
	];

	protected $fillable = [
		'userId',
		'badgeId'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}

	public function badge()
	{
		return $this->belongsTo(Badge::class, 'badgeId');
	}
}