<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SettingsClassificationFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(['Project','Program','Initiative','Campaign']);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => true,
        ];
    }
}
