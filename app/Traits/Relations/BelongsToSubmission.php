<?php declare(strict_types=1);

namespace App\Traits\Relations;

use App\Models\Submission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * BelongsToSubmission trait
 *
 * @property Submission $submission
 * @method Builder whereBelongsToSubmission(Model|Relation|integer|null $submission, bool $belongsToSubmission)
 * @method static Builder whereBelongsToSubmission(Model|Relation|integer|null $submission, bool $belongsToSubmission)
 */
trait BelongsToSubmission
{
	public function submission(): BelongsTo
	{
		return $this->belongsTo(Submission::class);
	}

	/**
	 * Scope a query to limit it to those that match a submission
	 *
	 * @param Builder $query
	 * @param Model|Relation|integer|null $submission
	 * @param bool $belongsToSubmission
	 * @return void
	 */
	public function scopeWhereBelongsToSubmission(Builder $query, $submission, bool $belongsToSubmission = true)
	{
		$operator = $belongsToSubmission ? '=' : '<>';
		ScopeRelation::scopeTo($query, $this->submission(), $submission, $operator);
	}
}
