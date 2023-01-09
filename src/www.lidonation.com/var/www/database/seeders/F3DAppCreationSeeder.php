<?php

namespace Database\Seeders;

class F3DAppCreationSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path().'/json/data/f3/dapp-creation/proposals.json';
        $proposals = collect(
            json_decode(file_get_contents($path))
        );
        $proposals->each(function ($p) {
            $proposal = $this->createProposal($p);
            $proposal->slug = "{$proposal->slug}-f3";

            $proposal->save();
        });
    }
}
