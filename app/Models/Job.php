<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Job extends Model
{
    use HasFactory;

	protected $table = 'jobs';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'jobId');
	}

}
