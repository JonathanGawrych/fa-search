<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Favorite;
use App\Models\Submission;
use App\Models\UserContact;
use App\Models\UserFavorite;
use App\Models\UserProfile;
use App\Models\UserStat;
use App\Models\Watch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $lower
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Collection $submissions
 * @property UserAvatar $avatar
 * @property UserStat $stats
 * @property UserFavorite $userFavorites
 * @property UserProfile $userProfile
 * @property UserContact $contacts
 * @property Collection $watches
 * @property Collection $watchedBy
 * @property Collection $favorites
 */
class User extends Model
{
	use HasFactory, SoftDeletes;

	public function submissions(): HasMany
	{
		return $this->hasMany(Submission::class);
	}

	public function avatar(): HasOne
	{
		return $this->hasOne(UserAvatar::class);
	}

	public function stats(): HasOne
	{
		return $this->hasOne(UserStat::class);
	}

	public function userFavorites(): HasOne
	{
		return $this->hasOne(UserFavorite::class);
	}

	public function profile(): HasOne
	{
		return $this->hasOne(UserProfile::class);
	}

	public function contacts(): HasOne
	{
		return $this->hasOne(UserContact::class);
	}

	public function watches(): BelongsToMany
	{
		$pivotInstance = new Watch();
		return $this->belongsToMany(
			self::class,
			Watch::class,
			$pivotInstance->user()->getForeignKeyName(),
			$pivotInstance->watchedUser()->getForeignKeyName()
		)
			->withPivot('id');
	}

	public function watchesPivot(): HasMany
	{
		$pivotInstance = new Watch();
		return $this->hasMany(Watch::class, $pivotInstance->user()->getForeignKeyName());
	}

	public function watchedBy(): BelongsToMany
	{
		$pivotInstance = new Watch();
		return $this->belongsToMany(
			self::class,
			Watch::class,
			$pivotInstance->watchedUser()->getForeignKeyName(),
			$pivotInstance->user()->getForeignKeyName()
		)
			->withPivot('id');
	}

	public function watchedByPivot(): HasMany
	{
		$pivotInstance = new Watch();
		return $this->hasMany(Watch::class, $pivotInstance->watchedUser()->getForeignKeyName());
	}

	public function favorites(): BelongsToMany
	{
		$pivotInstance = new Favorite();
		return $this->belongsToMany(
			Submission::class,
			Favorite::class,
			$pivotInstance->user()->getForeignKeyName(),
			$pivotInstance->submission()->getForeignKeyName()
		)
			->withPivot('id');
	}

	public function favoritesPivot(): HasMany
	{
		$pivotInstance = new Favorite();
		return $this->hasMany(Favorite::class, $pivotInstance->user()->getForeignKeyName());
	}

	public function shouts(): HasMany
	{
		return $this->hasMany(Shout::class);
	}
}
