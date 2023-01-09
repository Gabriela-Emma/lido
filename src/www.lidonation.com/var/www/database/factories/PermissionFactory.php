<?php

namespace Database\Factories\Spatie\Permission\Models;

use App\Enums\PermissionEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Enum\Faker\FakerEnumProvider;
use Spatie\Permission\Models\Permission;

class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new FakerEnumProvider($this->faker));

        return [
            'name' => $this->faker->randomEnumLabel(PermissionEnum::class),
        ];
    }
}
