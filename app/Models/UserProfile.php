<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Journal;
use App\Models\Submission;
use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_avatar_id
 * @property int $featured_submission_id
 * @property int $featured_journal_id
 * @property string $status
 * @property string $title
 * @property string $species
 * @property string $body
 * @property bool $accepting_trades
 * @property bool $accepting_commissions
 * @property bool $commission_tab_enabled
 * @property Carbon $member_since
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserProfile extends Model
{
	use HasFactory, BelongsToUser;

	/** @var array<string,string> **/
	protected $casts = [
		'accepting_trades' => 'boolean',
		'accepting_commissions' => 'boolean',
		'member_since' => 'datetime'
	];

	public function profileAvatar(): BelongsTo
	{
		return $this->belongsTo(Submission::class);
	}

	public function featuredSubmission(): BelongsTo
	{
		return $this->belongsTo(Submission::class);
	}

	public function featuredJournal(): BelongsTo
	{
		return $this->belongsTo(Journal::class);
	}
}
