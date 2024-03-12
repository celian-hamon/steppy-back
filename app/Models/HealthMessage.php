<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HealthMessage
 * 
 * @property int $id
 * @property string $message
 *
 * @package App\Models
 */
class HealthMessage extends Model
{
	protected $table = 'health_messages';
	public $timestamps = true;

	protected $fillable = [
		'message'
	];
}
