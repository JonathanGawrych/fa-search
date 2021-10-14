<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	public function up(): void
	{
		Schema::create('users', static function (Blueprint $table): void {
			$table->id();
			$table->string('lower')->unique();
			$table->string('name');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::drop('users');
	}
}
