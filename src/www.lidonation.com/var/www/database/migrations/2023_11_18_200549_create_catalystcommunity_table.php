<?php

use App\Enums\StatusEnum;
use App\Models\CatalystExplorer\CatalystCommunity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catalystcommunity', function (Blueprint $table) {
            $table->id();
            $table->title();
            $table->content();
            $table->user_id();
            $table->enum('status' , StatusEnum::values());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalystcommunity');
    }
};
