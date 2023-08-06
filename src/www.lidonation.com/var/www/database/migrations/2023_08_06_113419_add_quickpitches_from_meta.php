<?php

use App\Jobs\ProposalQuickPitchLength;
use App\Models\Meta;
use App\Models\Proposal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $metas = Meta::where('key', 'quick_pitch')
                ->orderBy('model_id')
                ->get();

        foreach ($metas as $meta) {
            $proposal = Proposal::find($meta->model_id);
            if ($proposal) {
                $proposal->quickpitch = $meta->content;
                $proposal->save();
                ProposalQuickPitchLength::dispatchSync($proposal);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meta', function (Blueprint $table) {
            //
        });
    }
};
