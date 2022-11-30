<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Label>
 */
class LabelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=> ucwords($this->faker->jobTitle),
            'color'=> ucwords($this->faker->colorName),
            'user_id'=>function(){
                return User::factory()->create()->id;
            }
        ];
    }
}
