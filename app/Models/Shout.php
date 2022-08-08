<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $shouter_id
 * @property string $text
 * @property Carbon $shouted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Shout extends Model
{
	use HasFactory, SoftDeletes;
	use BelongsToUser;

	/** @var array<string,string> $casts */
	protected $casts = [
		'shouted_at' => 'datetime'
	];

	public function shouter(): BelongsTo
	{
		return $this->belongsTo(User::class, 'shouter_user_id');
	}
}
