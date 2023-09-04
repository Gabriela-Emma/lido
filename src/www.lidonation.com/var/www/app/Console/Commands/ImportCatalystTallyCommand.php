<?php

namespace App\Console\Commands;

use App\Models\CatalystTally;
use Illuminate\Support\Fluent;
use JsonMachine\Items;
use Illuminate\Console\Command;

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
     */
    public function handle()
    {
        $file = $this->argument('file');
        $votesCast = Items::fromFile($file);

        foreach($votesCast as $data) {
            $data = new Fluent($data);
            CatalystTally::updateOrCreate([
                'hash' => $data->proposal_id,
            ], [
                'hash' => $data->proposal_id,
                'tally' => $data->votes_cast
            ]);
        }
    }
}
