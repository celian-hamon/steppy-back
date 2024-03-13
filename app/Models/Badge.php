<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Badge
 *
 * @property int $id
 * @property string $image
 * @property string $name
 * @property string $description
 *
 * @property Collection|Avatar[] $avatars
 * @property Collection|Challenge[] $challenges
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Badge extends Model
{
    use HasFactory;

    protected $table = 'badges';
	public $timestamps = true;

	protected $casts = [
		'avatarId' => 'int'
	];

	protected $hidden = [
		'pivot'
	];

	protected $fillable = [
		'image',
		'name',
		'description',
		'isGlobal',
		'isStreak',
		'quantity',
		'avatarId'
	];

	public function avatars()
	{
		return $this->hasOne(Avatar::class, 'id', 'avatarId');
	}

	public function challenges()
	{
		return $this->belongsToMany(Challenge::class, 'challenge_badge', 'badgeId', 'challengeId');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_badge', 'badgeId', 'userId');
	}
}
