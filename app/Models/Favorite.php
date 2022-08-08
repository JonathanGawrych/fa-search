<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Relations\BelongsToSubmission;
use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Support\Carbon;

/**
 * @property int $user_id
 * @property int $watched_user_id
 * @property Carbon $deleted_at
 */
class Favorite extends Model
{
	use HasFactory, AsPivot;
	use BelongsToUser, BelongsToSubmission;

	protected $table = 'favorites';
}
