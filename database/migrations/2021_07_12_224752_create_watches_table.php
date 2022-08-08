<?php declare(strict_types=1);

use App\Models\User;
use App\Models\Watch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchesTable extends Migration
{
	public function up(): void
	{
		Schema::create('watches', function (Blueprint $table): void {
			$table->id();
			$watchesColumn = $table->belongsTo(User::class);
			$watchedColumn = $table->belongsTo(User::class, 'watched_user_id');

			$table->unique([$watchesColumn->name, $watchedColumn->name]);
		});
	}

	public function down(): void
	{
		if (Watch::exists()) {
			throw new Exception('Cannot delete non-empty table');
		}
		Schema::drop('watches');
	}
}
