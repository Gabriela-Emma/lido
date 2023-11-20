<?php

use App\Enums\ContributionStatusEnum;
use App\Models\CatalystExplorer\Contribution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->title();
            $table->content();
            $table->model_type();
            $table->model_id();
            $table->user_id();
            $table->enum('status', ContributionStatusEnum::values());
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
