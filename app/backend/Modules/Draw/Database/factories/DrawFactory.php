<?php
namespace Modules\Draw\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DrawFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Draw\Entities\Draw::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('ru');

        return [
            'name' => $faker->word,
            'active' => true
        ];
    }
}

