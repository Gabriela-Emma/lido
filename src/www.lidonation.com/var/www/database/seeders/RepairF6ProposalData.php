<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use JsonMachine\JsonMachine;

class RepairF6ProposalData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path().'/json/data/f6/challenges.json';
        $funds = collect(
            json_decode(file_get_contents($path))
        );
        $funds->each(function ($f) {
            $path = storage_path()."/json/data/f6/{$f->id}/proposals.json";
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
                    $proposal->ideascale_link = $p['url'];
                    $proposal->save();
                }
            }
        });
    }
}
