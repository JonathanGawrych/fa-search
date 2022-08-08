<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContactsTable extends Migration
{
	public function up(): void
	{
		Schema::create('user_contacts', function (Blueprint $table): void {
			$table->id();
			$table->belongsTo(User::class);
			$table->string('home_site')->nullable();
			$table->string('skype')->nullable();
			$table->string('telegram')->nullable();
			$table->string('discord')->nullable();
			$table->string('battlenet')->nullable();
			$table->string('steam')->nullable();
			$table->string('xbox_live')->nullable();
			$table->string('second_life')->nullable();
			$table->string('play_station_network')->nullable();
			$table->string('wiiu')->nullable();
			$table->string('threeds')->nullable();
			$table->string('switch')->nullable();
			$table->string('imvu')->nullable();
			$table->string('so_furry')->nullable();
			$table->string('inkbunny')->nullable();
			$table->string('deviant_art')->nullable();
			$table->string('furry_network')->nullable();
			$table->string('transfur')->nullable();
			$table->string('tumblr')->nullable();
			$table->string('weasyl')->nullable();
			$table->string('youtube')->nullable();
			$table->string('twitter')->nullable();
			$table->string('facebook')->nullable();
			$table->string('dealers_den')->nullable();
			$table->string('furbuy')->nullable();
			$table->string('patreon')->nullable();
			$table->string('kofi')->nullable();
			$table->string('etsy')->nullable();
			$table->string('picarto')->nullable();
			$table->string('twitch_tv')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::drop('user_contacts');
	}
}
