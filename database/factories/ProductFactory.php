<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomDigit(),
            'description' => $this->faker->paragraph(), // password
            'image' => $this->faker->image(public_path('img'),640,480, null, false),
        ];
    }
}
