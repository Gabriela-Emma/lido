<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = Role::where('name', 'learner')->first();
        DB::table('users')
            ->whereNotExists(function ($query) use ($role) {
                $query->select(DB::raw(1))
                    ->from('model_has_roles')
                    ->whereRaw('model_has_roles.model_id = users.id')
                    ->whereRaw('model_has_roles.role_id = ?', [$role->id]);
            })
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
