<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class AddInitialUsers extends Migration
{
	public function up(): void
	{
		// Create our first two users
		User::create([
			'lower' => 'turingtibbit',
			'name' => 'TuringTibbit'
		]);

		User::create([
			'lower' => 'tibbittidbits',
			'name' => 'TibbitTidbits'
		]);
	}

	public function down(): void
	{
		User::where('lower', 'turingtibbit')->forceDelete();
		User::where('lower', 'tibbittidbits')->forceDelete();
	}
}
