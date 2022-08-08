<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissions extends Migration
{
	public function up(): void
	{
		Schema::create('submissions', function (Blueprint $table): void {
			$table->id()->autoIncrement(false)->primary();
			$table->belongsTo(User::class);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::drop('submissions');
	}
}
