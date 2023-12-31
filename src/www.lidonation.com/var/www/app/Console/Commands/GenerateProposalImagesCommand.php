<?php

namespace App\Console\Commands;

use App\Jobs\GenerateProposalImagesJob;
use App\Models\CatalystExplorer\Proposal;
use App\Repositories\ProposalRepository;
use Illuminate\Console\Command;

class GenerateProposalImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:generate-proposal-summary-images {proposal}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate summary picture of proposal.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(ProposalRepository $proposalRepository): void
    {
        GenerateProposalImagesJob::dispatchSync(Proposal::findOrFail($this->argument('proposal')));
    }
}
