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
        Schema::create('catalyst_ledger_snapshots', function (Blueprint $table) {
            $table->id();
            $table->text('snapshot_id')->unique();
            $table->bigInteger('size');
            $table->text('epoch');
            $table->text('slot');
            $table->foreignId('fund_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalyst_ledger_snapshots');
    }
};
