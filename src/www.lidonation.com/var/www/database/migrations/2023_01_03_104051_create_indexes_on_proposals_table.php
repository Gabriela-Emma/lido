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
//        \Illuminate\Support\Facades\DB::raw('ALTER TABLE proposals ALTER title TYPE JSONB USING title::JSONB');
        Schema::table('proposals', function (Blueprint $table) {
            $table->index('type');
            $table->index('title jsonb_path_ops')->algorithm('gin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['title']);
        });
//        \Illuminate\Support\Facades\DB::raw('ALTER TABLE proposals ALTER title TYPE JSON USING title::JSON');
    }
};
