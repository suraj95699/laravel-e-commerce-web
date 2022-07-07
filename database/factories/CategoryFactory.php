<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Category::class;
    public function definition()
    {
        return [
            'name'          =>  $this->faker->name,
            'description'   =>  $this->faker->realText(100),
            'parent_id'     =>  1,
            'menu'          =>  1,
        ];
    }
}
