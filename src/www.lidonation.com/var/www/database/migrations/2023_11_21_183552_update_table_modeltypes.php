<?php

use App\Models\Meta;
use App\Models\CatalystExplorer\Fund;
use Illuminate\Support\Facades\Schema;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\CatalystExplorer\CatalystTally;
use App\Models\CatalystExplorer\CatalystSnapshot;
use App\Models\CatalystExplorer\CatalystVotingPower;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        CatalystSnapshot::get()->each(
            function($c){
                $c->model_type = Fund::class;
                $c->save();
            }
        );

        Meta::where([
            'key' => 'snapshot_file_path',
            'model_type' => 'App\Models\CatalystSnapshot'
        ])->get()->each(
            function($m){
                $m->model_type = CatalystSnapshot::class;
                $m->save();
            }
        );

        CatalystTally::where([
            'model_type' => 'App\Models\Proposal',
            'context_type' => 'App\Models\Fund'
        ])->get()->each(
            function($c){
                $c->context_type = Fund::class;
                $c->model_type = Proposal::class;
                $c->save();
            }
        );


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
