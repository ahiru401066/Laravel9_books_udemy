<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'status' => $this->faker->randomElement([1,2,3,4]),
            'author' => $this->faker->name(),
            'publication' => $this->faker->name(),
            'read_at' => $this->faker->date(),
            'note' => $this->faker->realText(),
        ];
    }
}
