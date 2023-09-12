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
    public function up(): void
    {
        Schema::table('catalyst_tallies', function (Blueprint $table) {
            $table->bigInteger('context_id')->nullable();
            $table->text('context_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('catalyst_tallies', function (Blueprint $table) {
            $table->dropColumn(['context_id', 'context_type']);
        });
    }
};
