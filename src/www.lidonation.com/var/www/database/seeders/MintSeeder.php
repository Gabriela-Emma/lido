<?php

namespace Database\Seeders;

use App\Models\Mint;
use App\Models\MintTx;
use Illuminate\Database\Seeder;

class MintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mint::factory(10)
            ->has(MintTx::factory()
                ->count(random_int(2, 5))
                ->state(function (array $attributes, Mint $mint) {
                    return [ 
                        "mint_id" => $mint->id,
                        "user_id" => $mint->user_id,
                        "status" => $mint->status,
                    ];
                })
            , "txs")
            ->create();
    }
}
