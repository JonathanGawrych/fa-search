<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFavorites extends Migration
{
	public function up(): void
	{
		Schema::create('user_favorites', function (Blueprint $table): void {
			$table->id();
			$table->belongsTo(User::class);
			$table->string('music')->nullable();
			$table->string('media')->nullable();
			$table->string('games')->nullable();
			$table->string('gaming_platforms')->nullable();
			$table->string('animals')->nullable();
			$table->string('site')->nullable();
			$table->string('foods')->nullable();
			$table->string('quote')->nullable();
			$table->string('artists')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::drop('user_favorites');
	}
}
