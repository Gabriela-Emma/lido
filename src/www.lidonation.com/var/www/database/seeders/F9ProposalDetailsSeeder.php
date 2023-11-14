<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Str;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F9ProposalDetailsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     *
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        // save proposals
        $proposals = Items::fromFile(storage_path().'/json/data/f9/details.json');
        foreach ($proposals as $key => $p) {
            $ideascaleParts = explode('/', $p->proposal_link);
            $ideascaleId = $ideascaleParts[count($ideascaleParts) - 1];
            $proposal = Proposal::where(
                'ideascale_link',
                'LIKE',
                "%{$ideascaleId}-%"
            )->get()?->first();
            if (! $proposal || Str::length($proposal->content) > 150) {
                continue;
            }
            $content = $p?->content ?? '';

            if (Str::length($content) > 150) {
                $proposal->content = $content;

                $proposal->save();
            }
        }
    }
}
