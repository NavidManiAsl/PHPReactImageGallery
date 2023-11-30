<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
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
            'tags' => json_encode($this->faker->shuffleArray([1,2,3])),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'images' => json_encode($this->faker->shuffleArray([1,2,3])),
        ];
    }
}
