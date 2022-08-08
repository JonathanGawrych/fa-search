<?php declare(strict_types=1);

namespace App\Traits\Relations;

use App\Models\User;
use App\Traits\Relations\ScopeRelation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * BelongsToUser trait
 *
 * @property User $user
 * @method Builder whereBelongsToUser(Model|Relation|integer|null $user, bool $belongsToUser)
 * @method static Builder whereBelongsToUser(Model|Relation|integer|null $user, bool $belongsToUser)
 */
trait BelongsToUser
{
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Scope a query to limit it to those that match a user
	 *
	 * @param Builder $query
	 * @param Model|Relation|integer|null $user
	 * @param bool $belongsToUser
	 * @return void
	 */
	public function scopeWhereBelongsToUser(Builder $query, $user, bool $belongsToUser = true)
	{
		$operator = $belongsToUser ? '=' : '<>';
		ScopeRelation::scopeTo($query, $this->user(), $user, $operator);
	}
}
