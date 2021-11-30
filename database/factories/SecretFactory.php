<?php

namespace Database\Factories;

use App\Model\Secret;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecretFactory extends Factory
{
    protected $model = Secret::class;

    public function definition(): array
    {
    	return [
    	    'key' => $this->faker->randomNumber(),
            'value' => $this->faker->json_encode([$this->faker->randomNumber() => $this->faker->sentence()]),
            'created_at' => $this->faker->time('U'),
            'updated_at' => $this->faker->time('U')
    	];
    }
}
