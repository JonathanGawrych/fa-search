<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoutsTable extends Migration
{
	public function up(): void
	{
		Schema::create('shouts', function (Blueprint $table): void {
			$table->id()->autoIncrement(false)->primary();
			$table->belongsTo(User::class);
			$table->belongsTo(User::class, 'shouter_user_id');
			$table->text('text');
			$table->dateTime('shouted_at');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::drop('shouts');
	}
}
