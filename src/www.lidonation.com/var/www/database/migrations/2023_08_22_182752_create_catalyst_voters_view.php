<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
