<?php declare(strict_types=1);

namespace App\Traits\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class ScopeRelation
{
	/**
	 * Scope a query to a instance of or a relation to a Model
	 *
	 * @param Builder $query - The query to apply the scoping to
	 * @param Relation $relation - The source relation based off the model to be scoped from
	 * @param Model|Relation|integer|null $scope - An instance or relation that is to be scoped to
	 * @param string $operator - An optional param to invert the logic
	 * @return void
	 */
	public static function scopeTo(Builder $query, Relation $relation, $scope, string $operator = '=')
	{
		$key = null;
		if ($scope instanceof Model && ($relation instanceof BelongsTo || $relation instanceof HasOneOrMany)) {
			// Since we have the model, get the related attribute directly from it.
			$key = $scope->getAttribute(self::getNearKeyName($relation));

		} else if ($scope instanceof BelongsTo && self::getForeignKey($scope) !== null) {
			// Someone passed in a relation and the parent model has the key
			$key = self::getForeignKey($scope);

		} else if ($scope instanceof Relation) {
			// Passed in a relation to a model used in a query builder
			// This won't find a key, but rather set the column equal to another
			$query->whereColumn(
				self::getQualifiedFarKeyName($relation),
				$operator,
				self::getQualifiedFarKeyName($scope)
			);
			return;

		} else {
			// Passed in the key directly
			$key = $scope;
		}

		// Add a where the foreign key equals the value
		$query->where(self::getQualifiedFarKeyName($relation), $operator, $key);
	}

	/**
	 * @param BelongsTo|HasOneOrMany $relation
	 */
	private static function getNearKeyName(Relation $relation): string
	{
		if ($relation instanceof BelongsTo) {
			return $relation->getOwnerKeyName();
		} else {
			return $relation->getLocalKeyName();
		}
	}

	private static function getQualifiedFarKeyName(Relation $relation): string
	{
		if ($relation instanceof BelongsTo) {
			return $relation->getQualifiedForeignKeyName();
		} else {
			return $relation->getQualifiedParentKeyName();
		}
	}

	private static function getForeignKey(BelongsTo $belongsTo): ?mixed
	{
		return $belongsTo->getParent()->getAttribute($belongsTo->getForeignKeyName());
	}
}
