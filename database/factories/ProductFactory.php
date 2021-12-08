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
        $name = $this->faker->word();
        return [
            'name' => $name,
            'price' => $this->faker->randomDigit(),
            'description' => $this->faker->paragraph(), // password
            'image' => $this->faker->imageUrl(640,480, null, false, $name, true),
        ];
    }
}
