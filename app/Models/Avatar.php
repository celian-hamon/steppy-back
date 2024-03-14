<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Avatar
 *
 * @property int $id
 * @property string $image
 * @property string $name
 * @property int $badgeId
 *
 * @property Badge $badge
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Avatar extends Model
{
    use HasFactory;

    protected $table = 'avatar';
	public $timestamps = true;

	protected $casts = [
		'badgeId' => 'int'
	];

	protected $fillable = [
		'image',
		'name',
		'badgeId'
	];

	public function badge()
	{
		return $this->belongsTo(Badge::class, 'id', 'badgeId', );
	}

	public function users()
	{
		return $this->hasMany(User::class, 'avatarId');
	}
}
