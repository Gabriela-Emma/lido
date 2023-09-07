<?php

namespace App\Jobs;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProposalMeta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $proposals = [];

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Getting Proposals');
        $response = Http::get('https://core.projectcatalyst.io/api/v0/proposals');

        $responseData = json_decode($response->body());

        foreach ($responseData as $proposal) {
           
            if (isset($proposal->proposal_category) && $proposal->proposal_category->category_name === "Fund 10") {
            
                $this->proposals[] = $proposal;
            }
        }

        foreach ($this->proposals as $proposal) {
            $title = $proposal->proposal_title;
            
            $matchingProposal = Proposal::where('title->en', $title)->first();

            $jsonString = str_replace("'", '"', $proposal?->proposal_files_url);
            $dataObject = json_decode($jsonString);
            
            Log::info('Saving metadata for proposal');
            if ($matchingProposal) {
                $matchingProposal->saveMeta('chain_proposal_id', $proposal->chain_proposal_id, $matchingProposal, true);
                $matchingProposal->saveMeta('proposal_public_key', $proposal->proposal_public_key, $matchingProposal, true);
                $matchingProposal->saveMeta('projectcatalyst_io_url', $proposal->proposal_url, $matchingProposal, true);
                $matchingProposal->saveMeta('proposal_impact_score', $proposal->proposal_impact_score, $matchingProposal, true);
                $matchingProposal->saveMeta('chain_proposal_index', $proposal->chain_proposal_index, $matchingProposal, true);

                $matchingProposal->saveMeta('aligment_score', $dataObject?->aligment_score, $matchingProposal, true);
                $matchingProposal->saveMeta('auditability_score', $dataObject?->auditability_score, $matchingProposal, true);
                $matchingProposal->saveMeta('feasibility_score', $dataObject?->feasibility_score, $matchingProposal, true);

                $matchingProposal->opensource = ($dataObject->open_source === 'Yes') ? true : false;
                $matchingProposal->save();
            } else {
                Log::info('Not Found');
            }
        }
    }
}
