<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->name(),
            'path' => $this->faker->url(),
            'thumbnail_path' => $this->faker->url(),
            'description' => $this->faker->text(),
            'size' => $this->faker->numberBetween(10,1000),
            'dimension' => $this->faker->word(),
            'tags' => serialize($this->faker->shuffleArray()),
            'user_id' => function(){
                return User::factory()->create()->id;
            },
            'gallery_id' => function(){
               return Gallery::factory()->create()->id;
            } ,


        ];
    }
}
