<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;
use Database\Factories\Traits\UnsplashProvider;

class PromoSeeder extends Seeder
{
    use UnsplashProvider;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Promo::factory(5)->create()->each(
            function ($po) {
                $po->addMediaFromUrl($this->getRandomImageLink(2048, 2048))->toMediaCollection('hero');
            }
        );
    }
}
