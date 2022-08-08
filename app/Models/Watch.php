<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * @property int $id
 * @property int $user_id
 * @property int $watched_user_id
 */
class Watch extends Model
{
	use HasFactory, AsPivot;
	use BelongsToUser;

	protected $table = 'watches';

	public function watchedUser(): BelongsTo
	{
		return $this->belongsTo(User::class, 'watched_user_id');
	}
}
