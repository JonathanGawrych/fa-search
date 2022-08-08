<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStatsTable extends Migration
{
	public function up(): void
	{
		Schema::create('user_stats', function (Blueprint $table): void {
			$table->id();
			$table->belongsTo(User::class)->unique();
			$table->unsignedInteger('views');
			$table->unsignedInteger('submissions');
			$table->unsignedInteger('favs');
			$table->unsignedInteger('comments_received');
			$table->unsignedInteger('comments_made');
			$table->unsignedInteger('journals');
			$table->unsignedInteger('watches');
			$table->unsignedInteger('watched_by');
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::drop('user_stats');
	}
}
