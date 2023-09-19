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
        Schema::table('catalyst_voting_powers', function (Blueprint $table) {
            $table->index('voter_id', 'voter_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalyst_voting_powers', function (Blueprint $table) {

            $table->dropIndex('voter_id_index');
        });
    }
};
