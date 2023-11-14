<?php

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('discussions')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('legacy_comments')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('ratings')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('action_events')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('bookmark_items')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('catalyst_ranks')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('catalyst_snapshots')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('catalyst_tallies')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('catalyst_votes')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('flags')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('giveaway_model')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('learning_lessons')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('lido_reactions')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('media')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('metas')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_categories')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_has_permissions')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_has_roles')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_links')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_quiz')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_snippets')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_tags')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('model_wallets')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('nfts')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('repos')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('rewards')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('rules')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);

        DB::table('txes')->where('model_type', 'App\Models\Proposal')
            ->update(['model_type' => Proposal::class]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
