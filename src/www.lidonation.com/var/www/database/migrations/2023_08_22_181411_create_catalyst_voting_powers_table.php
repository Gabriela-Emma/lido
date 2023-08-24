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
        Schema::create('catalyst_voting_powers', function (Blueprint $table) {
            $table->id();
            $table->text('stake_pub');
            $table->float('voting_power');
            $table->foreignId('catalyst_snapshot_id')
                ->nullable()
                ->references('id')
                ->on('catalyst_snapshots');

                $table->unique(['stake_pub', 'catalyst_snapshot_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalyst_voting_powers');
    }
};
