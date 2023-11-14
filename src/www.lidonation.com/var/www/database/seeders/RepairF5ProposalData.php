<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use JsonMachine\JsonMachine;

class RepairF5ProposalData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // fix ideascale link
        $path = storage_path().'/json/data/f5/ideascale.json';
        $links = collect(
            json_decode(file_get_contents($path))
        );
        $links->each(function ($link) {
            $proposal = Proposal::where('ideascale_link', $link->short)->firstOrFail();
            $proposal->ideascale_link = $link->full;
            $proposal->save();
        });

        $path = storage_path().'/json/data/f5/challenges.json';
        $funds = collect(
            json_decode(file_get_contents($path))
        );
        $funds->each(function ($f) {
            $path = storage_path()."/json/data/f5/{$f->id}/proposals.json";
            $proposals = JsonMachine::fromFile($path);
            foreach ($proposals as $p) {
                $proposal = Proposal::whereHas(
                    'metas',
                    fn ($query) => $query->where([
                        'key' => 'ideascale_id',
                        'content' => $p['id'],
                    ]))->firstOrFail();
                if (isset($proposal)) {
                    $proposal->amount_requested = floatval(Str::replace(',', '', $p['amount']));
                    $proposal->title = $p['title'];
                    $proposal->save();
                }
            }
        });
    }
}
