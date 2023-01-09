<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Database\Seeder;

class FundOneProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path().'/json/fund1/proposals.json';
        $proposals = collect(
            json_decode(file_get_contents($path))
        );
        $proposals->each(function ($p) {
            $proposal = new Proposal;
            $proposal->title = $p->title;
            $proposal->website = $p->url ?? $p->ideascaleUrl;
            $proposal->problem = $p->problemDescription;
            $proposal->solution = $p->solutionDescription;
            $proposal->experience = $p->relevantExperience;
            $proposal->content = $p->description;
            $proposal->definition_of_success = $p->outcomeObjectives;
            $proposal->amount_requested = floatval($p->requestedAmount);
            $proposal->created_at = $p->createdAt;
            $proposal->title = $p->title;
            $proposal->fund = 'Fund 1';
            $proposal->status = 'pending';

            $ideascale = collect($p->ideascale);
            $ideascale->put('ideascaleUrl', $p->ideascaleUrl);
            $ideascale->put('ideascaleId', $p->ideascaleId);
            $proposal->meta_data = collect(['ideascale' => $ideascale->toArray()])->toJson();
            $proposal->save();
        });
    }
}
