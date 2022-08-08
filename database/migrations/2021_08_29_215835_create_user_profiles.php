<?php declare(strict_types=1);

use App\Models\Journal;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfiles extends Migration
{
	public function up(): void
	{
		Schema::create('user_profiles', function (Blueprint $table): void {
			$table->id();
			$table->belongsTo(User::class);
			$table->belongsTo(Submission::class, 'profile_avatar_id')->nullable();
			$table->belongsTo(Submission::class, 'featured_submission_id')->nullable();
			$table->belongsTo(Journal::class, 'featured_journal_id')->nullable();
			$table->string('status');
			$table->string('title')->nullable();
			$table->string('species')->nullable();
			$table->text('body');
			$table->boolean('accepting_trades');
			$table->boolean('accepting_commissions');
			$table->boolean('commission_tab_enabled');
			$table->dateTime('member_since');
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::drop('user_profiles');
	}
}
