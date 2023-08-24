<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('CREATE MATERIALIZED VIEW _catalyst_voters AS
                SELECT DISTINCT stake_pub, stake_key
                FROM catalyst_registrations'
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS _catalyst_voters');
    }
};
