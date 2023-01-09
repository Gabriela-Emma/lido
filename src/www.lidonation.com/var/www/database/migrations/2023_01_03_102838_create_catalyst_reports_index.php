<?php

use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;
use Tpetry\PostgresqlEnhanced\Schema\Concerns\ZeroDowntimeMigration;

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
        Schema::table('catalyst_reports', function (Blueprint $table) {
            $table->index('proposal_id');
            $table->fullText('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalyst_reports', function (Blueprint $table) {
            $table->dropIndexIfExists(['proposal_id']);
            $table->dropFullTextIfExists(['content']);
        });
    }
};
