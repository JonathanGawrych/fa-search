<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $music
 * @property string $media
 * @property string $games
 * @property string $gaming_platforms
 * @property string $animals
 * @property string $site
 * @property string $foods
 * @property string $quote
 * @property string $artists
 */
class UserFavorite extends Model
{
	use HasFactory, BelongsToUser;
}
