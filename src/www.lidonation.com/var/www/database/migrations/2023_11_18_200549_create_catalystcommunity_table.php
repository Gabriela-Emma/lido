<?php

use App\Enums\StatusEnum;
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
            $table->string('title');
            $table->text('content');
             $table->user_id();
            $table->enum('status' , [StatusEnum::DRAFT, StatusEnum::PENDING, StatusEnum::ACCEPTED, StatusEnum::SCHEDULE, StatusEnum::PUBLISHED]);
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
