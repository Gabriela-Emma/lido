<?php

use App\Models\Proposal;
use App\Models\Rating;
use App\Models\Discussion;
use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Schema\Concerns\ZeroDowntimeMigration;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    use ZeroDowntimeMigration;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::createMaterializedView(
            '_proposal_ratings',
            DB::table('ratings')
                ->selectRaw('ratings.id, ratings.rating, discussions.id as discussion_id, discussions.content as rationale, proposals.id as proposal_id, proposals.fund_id, proposals.status, proposals.user_id as primary_author')
                ->leftJoin('discussions',
                    fn($q) => $q->on('ratings.model_id', '=', 'discussions.id')
                        ->where('ratings.model_type', '=', Discussion::class)
                )
                ->rightJoin('proposals',
                    fn($q) => $q->on('discussions.model_id', '=', 'proposals.id')
                        ->where('discussions.model_type', '=', Proposal::class )
                )
        );
        Schema::table('_proposal_ratings', function (Blueprint $table) {
            $table->index('id');
            $table->index('proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropMaterializedViewIfExists('_proposal_ratings');
    }
};
