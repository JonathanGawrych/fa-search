<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
	protected $model = User::class;

	public function definition()
	{
		$name = $this->faker->name();
		return [
			'name' => $name,
			'lower' => strtolower($name)
		];
	}
}
