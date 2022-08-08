<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $views
 * @property int $submissions
 * @property int $favs
 * @property int $comments_received
 * @property int $comments_made
 * @property int $journals
 * @property int $watches
 * @property int $watched_by
 */
class UserStat extends Model
{
	use HasFactory, BelongsToUser;
}
