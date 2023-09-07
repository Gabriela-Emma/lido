<?php

use App\Models\BookmarkCollection;
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
        Schema::table('bookmark_collections', function (Blueprint $table) {
            $table->text('type')->default(BookmarkCollection::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookmark_collections', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
