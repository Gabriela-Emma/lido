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
        Schema::table('catalyst_groups', function (Blueprint $table) {
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalyst_groups', function (Blueprint $table) {
            $table->dropIndexIfExists(['slug']);
        });
    }
};
