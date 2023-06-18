<?php

use App\Enums\CatalystCurrencyEnum;
use App\Models\Fund;
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
        $fund = Fund::where('title', 'Fund 9')->first();
        
        if ($fund) {

            $proposals = $fund->parent_proposals()->where('proposals.type', 'challenge')->get();
            
            foreach ($proposals as $proposal) {
                $proposal->update(['currency' => CatalystCurrencyEnum::ADA]);
            }
        }
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
