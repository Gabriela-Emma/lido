<?php

namespace Database\Seeders;

use App\Models\Nft;
use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class NftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nft::factory()
            ->count(54)
            ->state(new Sequence(
                function ($sequence) {
                    $podcast = Podcast::all()->random();
                    return [
                        'model_id' => $podcast->id,
                        'model_type' => $podcast::class
                    ];
                },
            ))->create();
    }
}
