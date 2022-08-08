<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAvatarsTable extends Migration
{
	public function up(): void
	{
		Schema::create('user_avatars', function (Blueprint $table): void {
			$table->id();
			$table->belongsTo(User::class);
			$table->string('avatar_url_large')->nullable();
			$table->string('avatar_url_small')->nullable();
			$table->boolean('fa_plus')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::drop('user_avatars');
	}
}
