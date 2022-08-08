<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $avatar_url_large
 * @property string $avatar_url_small
 * @property bool $fa_plus
 */
class UserAvatar extends Model
{
	use HasFactory, BelongsToUser;

	protected $casts = [
		'fa_plus' => 'boolean'
	];
}
