<?php

namespace Database\Factories;

use App\Models\Secret;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecretFactory extends Factory
{
    protected $model = Secret::class;

    public function definition(): array
    {
        $time = $this->faker->time('U');
    	return [
    	    'key' => $this->faker->randomNumber(6),
            'value' => json_encode([$this->faker->randomNumber(4) => $this->faker->sentence()]),
            'created_at' => $time,
            'updated_at' => $time
    	];
    }

    public function keyone(){
        return $this->state([
            'key' => 'key1',
        ]);
    }
    public function keyvalue($key,$value){
        return $this->state([
            'key' => $key,
            'value' => json_encode($value),
        ]);
    }

    public function keytime($value,$time){
        return $this->state([
            'key' => 'mykey',
            'value' => json_encode($value),
            'created_at' => $time
        ]);
    }
}
