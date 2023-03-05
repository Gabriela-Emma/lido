<?php

namespace Database\Seeders;

class F3DeveloperEcosystemSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path().'/json/data/f3/developer-ecosystem/proposals.json';
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
