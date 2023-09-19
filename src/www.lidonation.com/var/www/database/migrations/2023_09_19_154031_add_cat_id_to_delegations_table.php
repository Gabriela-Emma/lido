<?php

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
        Schema::table('delegations', function (Blueprint $table) {
            $table->text('cat_onchain_id')->after('catalyst_registration_id')->nullable();
            $table->index('cat_onchain_id', 'cat_onchain_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delegations', function (Blueprint $table) {
            $table->dropColumn('cat_onchain_id');
            $table->dropIndex('cat_onchain_id_index');
        });
    }
};
