<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Fluent;
use JsonMachine\Items;

class F6ProposalJaLangSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \JsonMachine\Exception\InvalidArgumentException
     */
    public function run()
    {
        // save proposals
        foreach (Proposal::cursor() as $proposal) {
            $fundId = $proposal->fund->meta_data->ideascale_id;
            $proposalId = $proposal->meta_data->ideascale_id;
            if (! $fundId || ! $proposal) {
                continue;
            }

            $path = storage_path()."/json/data/f6/ja/$fundId/proposals/{$proposalId}.json";
            if (! file_exists($path)) {
                continue;
            }

            $pJa = new Fluent(
                Items::fromFile($path)
            );
            $pEn = new Fluent(
                Items::fromFile(storage_path()."/json/data/f6/$fundId/proposals/{$proposalId}.json")
            );

            $proposal->title = [
                'en' => $pEn->title,
                'ja' => $pJa->title,
            ];

            $proposal->problem = [
                'en' => $pEn->description,
                'ja' => $pJa?->description,
            ];

            $proposal->solution = [
                'en' => $pEn->solution,
                'ja' => $pJa?->solution,
            ];

            $proposal->experience = [
                'en' => $pEn->experience,
                'ja' => $pJa?->experience,
            ];

            $proposal->save();
        }
    }
}
