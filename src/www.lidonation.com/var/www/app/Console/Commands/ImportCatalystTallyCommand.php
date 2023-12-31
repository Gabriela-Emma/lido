<?php

namespace App\Console\Commands;

use App\Models\CatalystExplorer\CatalystTally;
use Illuminate\Console\Command;
use Illuminate\Support\Fluent;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class ImportCatalystTallyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:import-catalyst-tally {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Catalyst Votes Casts snapshot from a file.';

    /**
     * Execute the console command.
     *
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        $file = $this->argument('file');
        $votesCast = Items::fromFile($file);
        foreach ($votesCast as $data) {
            $data = new Fluent($data);
            foreach ($data->proposals as $value) {
                $proposalTally = new Fluent($value);
                CatalystTally::updateOrCreate([
                    'hash' => $proposalTally->proposal_id,
                ], [
                    'hash' => $proposalTally->proposal_id,
                    'tally' => $proposalTally->votes_cast,
                ]);
            }

        }
    }
}
