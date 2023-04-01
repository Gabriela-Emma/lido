<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Nft;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    protected $model = Promo::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $user = User::inRandomOrder()->first();
        $nft = Nft::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'title' => $this->faker->words(4, true),
            'token_type' => Nft::class,
            'token_id' => $nft->id,
            'status' => $this->faker->randomElement(['draft', 'scheduled', 'retired', 'published']),
            'type' => 'partner',
            'content' => ['en' => $this->faker->sentences(rand(2, 5), true), 'sw' => ''],

        ];
    }
}
