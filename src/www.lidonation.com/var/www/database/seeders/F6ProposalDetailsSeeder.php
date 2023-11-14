<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F6ProposalDetailsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function run()
    {
        // save proposals
        $proposals = Items::fromFile(storage_path().'/json/data/f6/details.json');
        foreach ($proposals as $key => $p) {
            $p = new Fluent($p);

            // save proposal
            $proposal = Proposal::whereHas(
                'links',
                fn ($q) => $q->where('link', $p?->Page_URL)
            )->first();
            $proposal->content = Str::remove(
                [
                    'Detailed plan (not required) - Fill in here any additional details',
                    'Detailed plan (not required)',
                    'Detailed plan',
                ],
                $p?->content
            );
            $proposal->save();
        }
    }
}
