<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Str;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F8ProposalDetailsSeeder extends FSeeder
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
        $proposals = Items::fromFile(storage_path().'/json/data/f8/details.json');
        foreach ($proposals as $key => $p) {
            $ideascaleParts = explode('/', $p->proposal_link);
            $ideascaleId = $ideascaleParts[count($ideascaleParts) - 1];
            $proposal = Proposal::where(
                'ideascale_link',
                'LIKE',
                "%{$ideascaleId}-%"
            )->get()?->first();
            if (! $proposal || Str::length($proposal->content) > 50) {
                continue;
            }
            $content = ($p?->p1 ?? '').'\n\n'.($p?->p2 ?? '').'\n\n'.($p->p3 ?? '').'\n\n'.($p->p4 ?? '');

            if (Str::length($content) > 50) {
                if ($proposal->type == 'proposal') {
                    $proposal->content = "[IMPACT]\n\n$content";
                } else {
                    $proposal->content = "$content";
                }

                $proposal->save();
            }
        }
    }
}
