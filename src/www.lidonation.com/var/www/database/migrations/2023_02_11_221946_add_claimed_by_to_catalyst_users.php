<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('catalyst_users', function (Blueprint $table) {
            $table->foreignId('claimed_by')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalyst_users', function (Blueprint $table) {
            $table->dropColumn('claimed_by');
            $table->dropIndexIfExists('catalyst_users_claimed_by_index');
        });
    }
};
