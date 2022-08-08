<?php declare(strict_types=1);

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
	public function up(): void
	{
		Schema::create('favorites', function (Blueprint $table): void {
			$table->id();
			$userColumn = $table->belongsTo(User::class);
			$submissionColumn = $table->belongsTo(Submission::class);
			$table->unique([$userColumn->name, $submissionColumn->name]);
		});
	}

	public function down(): void
	{
		Schema::drop('favorites');
	}
}
