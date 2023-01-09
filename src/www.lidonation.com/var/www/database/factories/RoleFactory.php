<?php

namespace Database\Factories\Spatie\Permission\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Enum\Faker\FakerEnumProvider;
use Spatie\Permission\Models\Role;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new FakerEnumProvider($this->faker));

        return [
            'name' => $this->faker->randomEnumLabel(RoleEnum::class),
        ];
    }
}
